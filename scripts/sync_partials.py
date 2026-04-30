#!/usr/bin/env python3
"""Sync partials/*.html into all *.html pages at the project root.

For each partial named `partials/NAME.html`, this script finds the block

    <!-- @partial:NAME -->
    ... cualquier contenido aquí se sobrescribe ...
    <!-- @end-partial:NAME -->

en cada `*.html` de la raíz y reemplaza el contenido por el del partial.
Si una página no tiene los marcadores, simplemente se ignora (no se
inyecta nada nuevo) — esto permite páginas con headers especiales.

Uso:
    python3 scripts/sync_partials.py            # propaga todos los partials
    python3 scripts/sync_partials.py --check    # falla si algo está fuera de sync
"""
from __future__ import annotations

import re
import sys
import pathlib

ROOT = pathlib.Path(__file__).resolve().parent.parent
PARTIALS_DIR = ROOT / "partials"


def load_partials() -> dict[str, str]:
    if not PARTIALS_DIR.is_dir():
        sys.exit(f"[!] Partials dir not found: {PARTIALS_DIR}")
    out: dict[str, str] = {}
    for f in sorted(PARTIALS_DIR.glob("*.html")):
        out[f.stem] = f.read_text(encoding="utf-8").rstrip() + "\n"
    if not out:
        sys.exit("[!] No partials/*.html files found")
    return out


def sync(check_only: bool = False) -> int:
    partials = load_partials()
    print(f"[+] Loaded {len(partials)} partial(s): {', '.join(partials)}")

    html_files = sorted(p for p in ROOT.glob("*.html") if p.is_file())
    if not html_files:
        sys.exit("[!] No *.html files found at project root")

    updated: list[str] = []
    out_of_sync: list[str] = []

    for f in html_files:
        text = f.read_text(encoding="utf-8")
        original = text

        for name, content in partials.items():
            # Marcadores tolerantes a espacios. Usamos `.*` (greedy) — no `.*?` —
            # para que, si por error quedaran restos entre el start y un end
            # falso (p. ej. comentarios documentando los markers), el sync
            # los limpie tomando el ÚLTIMO end como cierre real.
            pattern = re.compile(
                r"(<!--\s*@partial:" + re.escape(name) + r"\s*-->)"
                r".*"
                r"(<!--\s*@end-partial:" + re.escape(name) + r"\s*-->)",
                flags=re.DOTALL,
            )
            if pattern.search(text):
                text = pattern.sub(
                    lambda m: m.group(1) + "\n" + content + m.group(2),
                    text,
                )

        if text != original:
            if check_only:
                out_of_sync.append(f.name)
            else:
                f.write_text(text, encoding="utf-8")
                updated.append(f.name)

    if check_only:
        if out_of_sync:
            print("[!] Out of sync:")
            for name in out_of_sync:
                print(f"  - {name}")
            return 1
        print("[+] All HTML files are in sync.")
        return 0

    if updated:
        for name in updated:
            print(f"  ✓ {name}")
        print(f"[+] Synced {len(updated)} file(s).")
    else:
        print("[+] Nothing to update — all files already in sync.")
    return 0


if __name__ == "__main__":
    check = "--check" in sys.argv
    sys.exit(sync(check_only=check))
