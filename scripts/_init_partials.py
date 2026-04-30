#!/usr/bin/env python3
"""One-shot migration: add data-page="..." to <body> and wrap the existing
header block (skip-link + .hdr-wrap) with @partial markers.

Run ONCE. After this, sync_partials.py takes over for all future updates.
This script is safe to re-run: it's idempotent (won't double-wrap).
"""
from __future__ import annotations

import re
import sys
import pathlib

ROOT = pathlib.Path(__file__).resolve().parent.parent

# Map filename → data-page key
PAGE_KEYS = {
    "index.html":          "inicio",
    "quienes-somos.html":  "quienes-somos",
    "plataforma.html":     "plataforma",
    "entrenamiento.html":  "entrenamiento",
    "regiones.html":       "regiones",
    "canales.html":        "canales",
    "prensa.html":         "prensa",
    "eventos.html":        "eventos",
    # Páginas internas que viven dentro del bloque "Quiénes somos"
    "aliados.html":        "quienes-somos",
    "metricas.html":       "quienes-somos",
    "compromisos.html":    "quienes-somos",
    "propositos.html":     "quienes-somos",
}


def migrate(path: pathlib.Path, page_key: str) -> bool:
    text = path.read_text(encoding="utf-8")
    original = text

    # 1. <body> → <body data-page="...">
    if "data-page=" in text:
        # Idempotente: no se toca si ya lo tiene
        pass
    else:
        text = re.sub(
            r"<body(\s*)>",
            f'<body data-page="{page_key}">',
            text,
            count=1,
        )

    # 2. Si ya hay marcadores, no hacer nada
    if "<!-- @partial:header -->" in text:
        if text != original:
            path.write_text(text, encoding="utf-8")
            return True
        return False

    # 3. Buscar bloque header actual desde skip-link hasta </header>
    pattern = re.compile(
        r"(<a[^>]*class=\"skip-link\"[^>]*>.*?</a>\s*)"
        r"(?:<!--[^>]*?HEADER[^>]*?-->\s*)?"
        r"(<header[^>]*class=\"hdr-wrap\"[^>]*>.*?</header>)",
        flags=re.DOTALL,
    )
    m = pattern.search(text)
    if not m:
        print(f"  [!] {path.name}: no se encontró bloque header — saltado")
        if text != original:
            path.write_text(text, encoding="utf-8")
            return True
        return False

    replacement = (
        "<!-- @partial:header -->\n"
        "  <!-- Auto-generado desde partials/header.html — no editar a mano. -->\n"
        "  <!-- Fuente: python3 scripts/sync_partials.py -->\n"
        + m.group(1)
        + "\n"
        + m.group(2)
        + "\n"
        + "  <!-- @end-partial:header -->"
    )
    text = text[:m.start()] + replacement + text[m.end():]

    if text != original:
        path.write_text(text, encoding="utf-8")
        return True
    return False


def main() -> int:
    changed = 0
    for fname, key in PAGE_KEYS.items():
        p = ROOT / fname
        if not p.exists():
            print(f"  [—] {fname}: no existe — saltado")
            continue
        if migrate(p, key):
            print(f"  ✓ {fname} (data-page=\"{key}\")")
            changed += 1
        else:
            print(f"  • {fname}: sin cambios")
    print(f"[+] Migrados {changed} archivo(s).")
    print("[+] Ahora corre: python3 scripts/sync_partials.py")
    return 0


if __name__ == "__main__":
    sys.exit(main())
