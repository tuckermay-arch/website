#!/usr/bin/env python3
"""Turn a theme page pattern into paste-ready block markup for the WordPress code editor.

Usage: python3 tools/export_page.py page-portfolio [more slugs...]
Writes dist/paste/<slug>.txt with the live site's addresses filled in.
"""
import os
import re
import sys

SITE = 'https://tuckermay.com'
THEME = SITE + '/wp-content/themes/tuckermay'
SUBSTACK = 'https://tuckermaymysteries.substack.com'
ROOT = os.path.join(os.path.dirname(__file__), '..')


def export(slug):
    src = open(os.path.join(ROOT, 'theme', 'tuckermay', 'patterns', slug + '.php')).read()
    body = src.split('?>', 1)[1].strip()  # drop the PHP header comment
    body = re.sub(r"<\?php echo esc_url\( home_url\( '([^']*)' \) \); \?>", lambda m: SITE + m.group(1), body)
    body = re.sub(r"<\?php echo esc_url\( get_theme_file_uri\( '([^']*)' \) \); \?>", lambda m: THEME + '/' + m.group(1), body)
    body = body.replace("<?php echo esc_url( tuckermay_substack_url() . '/subscribe' ); ?>", SUBSTACK + '/subscribe')
    if '<?php' in body:
        raise SystemExit(f'{slug}: unconverted PHP left in pattern')
    out_dir = os.path.join(ROOT, 'dist', 'paste')
    os.makedirs(out_dir, exist_ok=True)
    path = os.path.join(out_dir, slug + '.txt')
    open(path, 'w').write(body + '\n')
    return path


if __name__ == '__main__':
    for s in sys.argv[1:]:
        print(export(s))
