#!/usr/bin/env python3
"""Generate the theme's block patterns (theme/tuckermay/patterns/*.php).

Block markup is produced by small helpers so every block matches what the
WordPress editor itself would save. Run: python3 tools/build_patterns.py
"""
import json
import os
from html import escape

OUT = os.path.join(os.path.dirname(__file__), '..', 'theme', 'tuckermay', 'patterns')


# ---------------------------------------------------------------- helpers
def IMG(name):
    return f"<?php echo esc_url( get_theme_file_uri( 'assets/images/{name}' ) ); ?>"


def PDF(name):
    return f"<?php echo esc_url( get_theme_file_uri( 'assets/pdfs/{name}' ) ); ?>"


def URL(path):
    return f"<?php echo esc_url( home_url( '{path}' ) ); ?>"


SUBSTACK_SUBSCRIBE = "<?php echo esc_url( tuckermay_substack_url() . '/subscribe' ); ?>"


def _a(d):
    d = {k: v for k, v in d.items() if v not in (None, '', {})}
    return (' ' + json.dumps(d, separators=(',', ':'), ensure_ascii=False)) if d else ''


def _cls(base, extra):
    return base + (' ' + extra if extra else '')


def join(parts):
    return '\n\n'.join(p for p in parts if p)


def group(children, cls=None, tag='div', layout=None, anchor=None):
    a = {}
    if tag != 'div':
        a['tagName'] = tag
    if anchor:
        a['anchor'] = anchor
    a['className'] = cls
    a['layout'] = layout
    idattr = f' id="{anchor}"' if anchor else ''
    return (f'<!-- wp:group{_a(a)} -->\n<{tag}{idattr} class="{_cls("wp-block-group", cls)}">'
            + join(children) + f'</{tag}>\n<!-- /wp:group -->')


def p(html, cls=None):
    c = f' class="{cls}"' if cls else ''
    return f'<!-- wp:paragraph{_a({"className": cls})} -->\n<p{c}>{html}</p>\n<!-- /wp:paragraph -->'


def h(level, html, cls=None, anchor=None):
    a = {}
    if level != 2:
        a['level'] = level
    if anchor:
        a['anchor'] = anchor
    a['className'] = cls
    idattr = f' id="{anchor}"' if anchor else ''
    return (f'<!-- wp:heading{_a(a)} -->\n<h{level}{idattr} class="{_cls("wp-block-heading", cls)}">{html}</h{level}>\n'
            f'<!-- /wp:heading -->')


def img(src, alt, cls=None, href=None, blank=False, caption=None, lightbox=False):
    a = {'lightbox': {'enabled': True}} if lightbox else {}
    a.update({'sizeSlug': 'full', 'linkDestination': 'custom' if href else 'none', 'className': cls})
    tag = f'<img src="{src}" alt="{escape(alt, quote=True)}"/>'
    if href:
        tgt = ' target="_blank" rel="noreferrer noopener"' if blank else ''
        tag = f'<a href="{href}"{tgt}>{tag}</a>'
    cap = f'<figcaption class="wp-element-caption">{caption}</figcaption>' if caption else ''
    return (f'<!-- wp:image{_a(a)} -->\n<figure class="{_cls("wp-block-image size-full", cls)}">{tag}{cap}</figure>\n'
            f'<!-- /wp:image -->')


def button(text, href, outline=False, cls=None, blank=False):
    klass = ' '.join(x for x in ['is-style-outline' if outline else '', cls or ''] if x) or None
    tgt = ' target="_blank" rel="noreferrer noopener"' if blank else ''
    return (f'<!-- wp:button{_a({"className": klass})} -->\n<div class="{_cls("wp-block-button", klass)}">'
            f'<a class="wp-block-button__link wp-element-button" href="{href}"{tgt}>{text}</a></div>\n<!-- /wp:button -->')


def buttons(*btns, cls=None):
    return (f'<!-- wp:buttons{_a({"className": cls})} -->\n<div class="{_cls("wp-block-buttons", cls)}">'
            + join(btns) + '</div>\n<!-- /wp:buttons -->')


def lst(items, cls=None, ordered=False):
    tag = 'ol' if ordered else 'ul'
    a = {'ordered': True} if ordered else {}
    a['className'] = cls
    lis = join(f'<!-- wp:list-item -->\n<li>{i}</li>\n<!-- /wp:list-item -->' for i in items)
    return f'<!-- wp:list{_a(a)} -->\n<{tag} class="{_cls("wp-block-list", cls)}">{lis}</{tag}>\n<!-- /wp:list -->'


def columns(cols, cls=None):
    return (f'<!-- wp:columns{_a({"className": cls})} -->\n<div class="{_cls("wp-block-columns", cls)}">'
            + join(cols) + '</div>\n<!-- /wp:columns -->')


def column(children, cls=None):
    return (f'<!-- wp:column{_a({"className": cls})} -->\n<div class="{_cls("wp-block-column", cls)}">'
            + join(children) + '</div>\n<!-- /wp:column -->')


def details(q, answer_html, cls='tm-faq'):
    return (f'<!-- wp:details{_a({"className": cls})} -->\n<details class="{_cls("wp-block-details", cls)}"><summary>{q}</summary>'
            + p(answer_html) + '</details>\n<!-- /wp:details -->')


def sc(code):
    return f'<!-- wp:shortcode -->\n{code}\n<!-- /wp:shortcode -->'


def section_head(eyebrow, title, lede=None, level=2):
    return group([p(eyebrow, 'tm-eyebrow'), h(level, title), p(lede, 'tm-lede') if lede else None], 'tm-section-head')


def write(slug, title, body, cats='tuckermay', block_types=None, post_types=None, inserter=True, desc=''):
    lines = ['<?php', '/**', f' * Title: {title}', f' * Slug: tuckermay/{slug}', f' * Categories: {cats}']
    if desc:
        lines.append(f' * Description: {desc}')
    if block_types:
        lines.append(f' * Block Types: {block_types}')
    if post_types:
        lines.append(f' * Post Types: {post_types}')
    if not inserter:
        lines.append(' * Inserter: no')
    lines.append(' * Viewport width: 1400')
    lines += [' *', ' * @package tuckermay', ' */', '?>']
    with open(os.path.join(OUT, f'{slug}.php'), 'w') as f:
        f.write('\n'.join(lines) + '\n' + body + '\n')


def page(slug, title, body, desc):
    write(slug, title, group(body, 'tm-page'), cats='tuckermay-pages', block_types='core/post-content',
          post_types='page', desc=desc)


AMZ_DOB = 'https://a.co/d/0a47KAUl'
AMZ_LHM = 'https://a.co/d/05ZV8bDo'
PAYPAL = 'https://www.paypal.com/ncp/payment/ZWBQS9N9BLE6G'
PAYPAL_BIWEEKLY = 'https://www.paypal.com/ncp/payment/JTAVSWRCAD25U'
PAYPAL_MONTHLY = 'https://www.paypal.com/ncp/payment/VZH39TD9YFLHA'
COMEDY = '/comedy-ghostwriting/'
TOOLKIT = 'https://writinglessonseverywhere.netlify.app/'
TS4 = 'https://tuckermaymysteries.substack.com/p/toy-story-4-writing-lesson'
IG = 'https://www.instagram.com/tuckermaymysteries/'
BSKY = 'https://bsky.app/profile/tuckermaymysteries.bsky.social'
FB = 'https://www.facebook.com/people/Tucker-May-Mysteries/61556491591135/'

DOB_SHORT = ('The richest man in the world is dead. Alan Benning is the main suspect. Can he save himself and his '
             'family by finding the real killer?')
LHM_SHORT = ('A killer stalks the halls of Lemon House, a low-rent live-in drug rehabilitation center. Two residents '
             'must risk life and limb to prove their main suspect’s guilt while also navigating the stormy waves of '
             'early sobriety.')
LDG_TEASER = ('When a creative loner’s best friend goes missing, the quest to find him uncovers a conspiracy that '
              'threatens all of existence as we know it.')


# ---------------------------------------------------------------- shared pieces
def formats(items):
    return lst(items, 'tm-formats')


def offer_dark():
    return group([
        p('Risk-free trial', 'tm-trial-badge'),
        group([h(3, 'Custom one-sheet'), p('$250', 'tm-price')], 'tm-offer-head'),
        lst(['10 punch-up jokes', '5 customized intros, transitions, or ad throws', 'Delivered within 5 days',
             'First order? Money back if you don’t use a single joke'], 'tm-checks'),
        buttons(button('Buy now', PAYPAL, blank=True, cls='tm-btn-light')),
    ], 'tm-offer tm-offer--dark')


def package(name, price, per, items, href, badge=None, cls=''):
    parts = [p(badge, 'tm-pk-badge')] if badge else []
    parts += [h(3, name), p(price, 'tm-pk-price'), p(per, 'tm-pk-per'), lst(items, 'tm-checks'),
              buttons(button('Buy now', href, blank=True))]
    return group(parts, ('tm-pk ' + cls).strip())


def review():
    return group([p('★★★★★', 'tm-stars'), p('[Review quote]', 'tm-review-quote'),
                  p('[Reviewer, source]', 'tm-review-by')], 'tm-review')


def panel(children, cls='', anchor=None):
    return group(children, ('tm-panel ' + cls).strip(), anchor=anchor)


def entry_screenplay():
    return group([
        group([p('[Genre]', 'tm-meta'), h(2, '[Screenplay title]', 'tm-entry-title'), p('[Logline]', 'tm-logline'),
               p('[Brief summary, two or three sentences.]', 'tm-entry-summary')], 'tm-entry-body'),
        buttons(button('Request script', '#request-form', cls='tm-request-btn')),
    ], 'tm-entry tm-panel')


def entry_tv(kind='Original pilot'):
    return group([
        group([p(kind, 'tm-chip'), h(2, '[Show title]', 'tm-entry-title'), p('[Logline]', 'tm-logline')],
              'tm-entry-body'),
        buttons(button('Read the script ↗', '#', blank=True)),
    ], 'tm-entry tm-panel')


def entry_story(kind='Short story', external=False):
    body = [p(kind, 'tm-chip'), h(3, '[Title]', 'tm-entry-title')]
    if external:
        body.append(p('Published in [Publication]', 'tm-entry-summary'))
    btn = button('Read at [Publication] ↗', '#', outline=True, blank=True) if external else button('Read', '#')
    return group([group(body, 'tm-entry-body'), buttons(btn)], 'tm-entry tm-panel')


# ---------------------------------------------------------------- header / footer
def header():
    brand = group([
        img(IMG('tm-mark.png'), 'Tucker May Books', 'tm-logo', href=URL('/')),
        img(IMG('tucker-header.jpg'), 'Tucker May', 'tm-photo'),
        group([p(f'<a href="{URL("/")}">Tucker May</a>', 'tm-name'),
               p('Novels · Comedy Writing · A Community for Writers', 'tm-sub')], 'tm-id'),
    ], 'tm-brand', layout={'type': 'flex', 'flexWrap': 'nowrap'})
    links = [('Books', '/novels/'), ('Writing Lessons Everywhere', '/writing-lessons-everywhere/'),
             ('Comedy Ghostwriting', COMEDY), ('YouTube Scripts', '/youtube-scripts/')]
    nav = ['<!-- wp:navigation {"overlayMenu":"mobile","className":"tm-nav","layout":{"type":"flex","flexWrap":"wrap"}} -->']
    for label, path in links:
        nav.append(f'<!-- wp:navigation-link {{"label":"{label}","url":"{URL(path)}","kind":"custom"}} /-->')
    nav.append(f'<!-- wp:navigation-submenu {{"label":"Other Writing","url":"{URL("/portfolio/")}","kind":"custom"}} -->')
    for label, path in [('Screenplays', '/screenplays/'), ('TV Shows', '/tv-shows/'),
                        ('Poetry / Short Stories', '/poetry-prose/'), ('Sketch Comedy', '/sketch-comedy/')]:
        nav.append(f'<!-- wp:navigation-link {{"label":"{label}","url":"{URL(path)}","kind":"custom"}} /-->')
    nav.append('<!-- /wp:navigation-submenu -->')
    for label, path in [('Blog', '/blog/'), ('About', '/about/'), ('Contact', '/contact/')]:
        nav.append(f'<!-- wp:navigation-link {{"label":"{label}","url":"{URL(path)}","kind":"custom"}} /-->')
    nav.append('<!-- /wp:navigation -->')
    write('header', 'Site header', group([brand, '\n'.join(nav)], 'tm-header-inner'),
          block_types='core/template-part/header', inserter=False)


def footer():
    body = group([
        p(f'© [tm_year] Tucker May <a href="{URL("/privacy-policy/")}">Privacy Policy</a>', 'tm-copy'),
        p(f'<a href="{IG}" target="_blank" rel="noreferrer noopener">Instagram</a> '
          f'<a href="{BSKY}" target="_blank" rel="noreferrer noopener">Bluesky</a> '
          f'<a href="{FB}" target="_blank" rel="noreferrer noopener">Facebook</a> '
          f'<a href="{URL("/contact/")}">Contact</a>', 'tm-foot-links'),
    ], 'tm-footer-inner')
    write('footer', 'Site footer', body, block_types='core/template-part/footer', inserter=False)


# ---------------------------------------------------------------- home
def home():
    books = column([
        group([
            p('Mystery novels', 'tm-kicker'),
            h(2, 'Books', 'screen-reader-text'),
            group([img(IMG('cover-death-of-a-billionaire.jpg'), 'Death of a Billionaire by Tucker May', href=AMZ_DOB, blank=True),
                   img(IMG('cover-the-lemon-house-murders.jpg'), 'The Lemon House Murders by Tucker May', href=AMZ_LHM, blank=True)],
                  'tm-covers'),
        ], 'tm-card-head'),
        group([
            columns([
                column([formats(['Hardcover', 'Paperback', 'Kindle', 'Audiobook']),
                        buttons(button('Buy on Amazon', AMZ_DOB, blank=True))]),
                column([formats(['Hardcover', 'Paperback', 'Kindle']),
                        buttons(button('Buy on Amazon', AMZ_LHM, blank=True))]),
            ], 'tm-shelf'),
            group([
                p('Hover over a cover to read what the book is about.', 'tm-summary-hint'),
                group([h(3, 'Death of a Billionaire'), p(DOB_SHORT)], 'tm-summary'),
                group([h(3, 'The Lemon House Murders'), p(LHM_SHORT)], 'tm-summary'),
            ], 'tm-summaries'),
            group([
                img(IMG('cover-the-last-dead-guy-in-hell.jpg'), 'The Last Dead Guy in Hell by Tucker May', 'tm-soon-cover'),
                group([p('Coming soon', 'tm-eyebrow'), h(3, 'The Last Dead Guy in Hell'),
                       p('Be the first to hear the release date.', 'tm-note')], 'tm-soon-text'),
                sc('[tm_book_signup]'),
            ], 'tm-soon'),
        ], 'tm-card-body'),
        p(f'<a href="{URL("/novels/")}">All books and reviews</a>', 'tm-card-foot'),
    ], 'tm-card tm-card--books')

    wle = column([
        group([
            p('Weekly newsletter on Substack', 'tm-kicker'),
            img(IMG('wle-wordmark.jpg'), 'Writing Lessons Everywhere: Source, Mechanism, Tool', 'tm-wle-wordmark', href=URL('/writing-lessons-everywhere/')),
            p('Writing lessons from the pop culture in the headlines.', 'tm-tag'),
        ], 'tm-card-head tm-wle-head'),
        group([
            p('Join a community of writers working through their drafts together. Every post breaks down a movie, '
              'show, or book and comes with a worksheet for your own draft.'),
            sc('[tm_substack_signup]'),
            p('If you need to refine your draft but can’t drop thousands of dollars on a book coach or narrative '
              'consultant, then Writing Lessons Everywhere is exactly what you need.', 'tm-pitch'),
            p(f'Become a paid subscriber to access every WLE worksheet in the Under the Hood Toolkit. '
              f'<a href="{TOOLKIT}" target="_blank" rel="noreferrer noopener">See the whole database here →</a>', 'tm-pitch'),
            p('Latest posts', 'tm-label'),
            sc('[tm_substack_posts count="2"]'),
        ], 'tm-card-body'),
        p(f'<a href="{URL("/writing-lessons-everywhere/")}">About the newsletter</a>', 'tm-card-foot'),
    ], 'tm-card tm-card--wle')

    comedy = column([
        group([
            p('For podcasts and YouTube channels', 'tm-kicker'),
            h(2, f'<a href="{URL(COMEDY)}">Comedy Ghostwriting</a>', 'tm-head-link'),
            p('Custom jokes and ad throws for your next episode or video.', 'tm-tag'),
        ], 'tm-card-head'),
        group([
            p('Alum of Northwestern’s Mee-Ow sketch show. Has written for comedy teams at The Second City, iO, and iO West.',
              'tm-creds'),
            offer_dark(),
            p(f'<a href="{URL(COMEDY)}#packages">Retainers from $450/month with 3-day delivery →</a>', 'tm-retainer-line'),
        ], 'tm-card-body'),
        p(f'<a href="{URL(COMEDY)}">Packages, samples, and FAQ</a>', 'tm-card-foot'),
    ], 'tm-card tm-card--comedy')

    write('page-home', 'Home page', group([columns([books, wle, comedy], 'tm-cards')], 'tm-home'),
          cats='tuckermay-pages', block_types='core/post-content', post_types='page',
          desc='Three cards: Books, Writing Lessons Everywhere, Comedy Ghostwriting.')


# ---------------------------------------------------------------- novels
def novels():
    def desc(paras, fans):
        return group([p(paras[0], 'tm-hook')] + [p(x) for x in paras[1:]] + [p(fans, 'tm-fans')], 'tm-desc')

    dob = group([
        img(IMG('cover-death-of-a-billionaire.jpg'), 'Death of a Billionaire by Tucker May', 'tm-book-cover', href=AMZ_DOB, blank=True),
        group([
            p('A murder mystery novel', 'tm-eyebrow'), h(2, 'Death of a Billionaire'),
            desc(['Ever dream of killing your boss? Alan Benning knows how you feel.',
                  'The problem: his billionaire boss actually winds up murdered. And the whole world thinks he did it.',
                  'When globetrotting tech billionaire Barron Fisk is found dead on the floor of his swanky Silicon Valley office, all evidence points to Alan.',
                  'Alan must venture into the glitzy, treacherous world of tech billionaires to clear his name by sorting through a long list of suspects with motive aplenty. If he can’t find the real culprit, Alan’s going down. The clock is ticking.',
                  'Who killed Barron Fisk? The truth will shock—and change—the entire world.'],
                 'Fans of Richard Osman’s <em>The Thursday Murder Club</em> series, Carl Hiaasen’s tales of high-stakes hijinx, or Ruth Ware’s page-turning mysteries will love <em>Death of a Billionaire</em>.'),
            formats(['Hardcover', 'Paperback', 'Kindle', 'Audiobook']),
            buttons(button('Buy on Amazon', AMZ_DOB, blank=True)),
            group([review(), review(), review()], 'tm-reviews'),
        ], 'tm-book-info'),
    ], 'tm-book tm-panel')

    lhm = group([
        img(IMG('cover-the-lemon-house-murders.jpg'), 'The Lemon House Murders by Tucker May', 'tm-book-cover', href=AMZ_LHM, blank=True),
        group([
            p('Readers’ Favorite five-star review', 'tm-badge'), h(2, 'The Lemon House Murders'),
            desc(['A string of mysterious deaths . . . A house full of suspects . . . A secret that will change everything . . .',
                  'When residents of a live-in drug rehabilitation facility called Lemon House start dying one by one, no one in the outside world seems to care.',
                  'Two Lemon House patients, nicknamed Trip and Gobstopper, are the only ones who can see the truth: these are murders.',
                  'Their quest to find the killer will push their budding relationship to the brink, cast suspicion on everyone locked in the house with them, and force them to question their most cherished beliefs.',
                  '<em>The Lemon House Murders</em> is the rare murder mystery that will have you guessing at the culprit AND thinking deeply about theology, society’s relationship toward the downtrodden, and the importance of self-determination to a fulfilling life.'],
                 'Fans of Agatha Christie, Ruth Ware, and locked-room mysteries of all kinds will LOVE <em>The Lemon House Murders</em>.'),
            formats(['Hardcover', 'Paperback', 'Kindle']),
            buttons(button('Buy on Amazon', AMZ_LHM, blank=True)),
            group([review(), review(), review()], 'tm-reviews'),
        ], 'tm-book-info'),
    ], 'tm-book tm-panel')

    soon = group([
        img(IMG('cover-the-last-dead-guy-in-hell.jpg'), 'The Last Dead Guy in Hell by Tucker May', 'tm-book-cover'),
        group([p('Coming soon', 'tm-eyebrow'), h(2, 'The Last Dead Guy in Hell'), p(LDG_TEASER, 'tm-lede'),
               p('Be the first to hear the release date.'), sc('[tm_book_signup]')], 'tm-book-info'),
    ], 'tm-book tm-book--soon tm-panel')

    cross = group([
        group([p('Also by Tucker', 'tm-eyebrow'), h(2, 'Writing Lessons Everywhere'),
               p('A free weekly newsletter that turns the movies, shows, and books you love into lessons for your own draft.')]),
        buttons(button('Subscribe free', URL('/writing-lessons-everywhere/'), cls='tm-btn-blue')),
    ], 'tm-cross')

    page('page-novels', 'Novels page', [
        group([p('Mystery novels', 'tm-eyebrow'), h(1, 'The Novels'),
               p('Standalone murder mysteries by Tucker May. Start with either one.', 'tm-lede')], 'tm-hero'),
        dob, lhm, soon, cross,
    ], 'All three books with descriptions, buy buttons, review quotes, and the Coming Soon signup.')


# ---------------------------------------------------------------- writing lessons everywhere
def wle():
    hero = group([
        group([p('Weekly newsletter on Substack', 'tm-eyebrow'), h(1, 'Feeling stuck with your WIP?'),
               p('You know the feeling: you’re reading through a draft of your novel, screenplay, or TV spec and something just feels off. But you can’t quite put your finger on why.', 'tm-lede'),
               p('Don’t give up on your draft. The problem isn’t you. It’s structure, character motivation, setup and payoff, or some other diagnosable and fixable issue.', 'tm-lede'),
               sc('[tm_substack_signup]')], 'tm-hero'),
        img(IMG('wle-logo.jpg'), 'Writing Lessons Everywhere: Source, Mechanism, Tool', 'tm-wle-logo'),
    ], 'tm-split')

    smt = group([
        section_head('How every post works', 'Source → Mechanism → Tool',
                     'Every week: practical writing lessons from the pop culture currently making headlines, each with a tool to apply the lesson to your WIP. Here’s one from a recent post.'),
        group([
            group([p('Source', 'tm-step'), h(3, 'Toy Story 4'),
                   p('For three films, Woody is loyal to his kid. By the end of Toy Story 4, he walks away from his kid. Instead of feeling like a betrayal, it has viewers reaching for Kleenex. Why?')], 'tm-smt-step'),
            group([p('Mechanism', 'tm-step'), h(3, 'Sell the want so the need lands'),
                   lst(['Sell the want', 'Hide the need in plain sight', 'Honor the want before subverting it'], ordered=True),
                   p('The need fades into background noise until the climax forces it front and center.')], 'tm-smt-step'),
            group([p('Tool', 'tm-step'), h(3, 'A want/need worksheet'),
                   p('A new Under the Hood Toolkit worksheet for building a healthy want/need journey for any character. Free for two weeks, like every WLE tool.'),
                   p(f'<a href="{TS4}" target="_blank" rel="noreferrer noopener">Read the full post →</a>', 'tm-more-link')], 'tm-smt-step'),
        ], 'tm-smt'),
    ])

    plans = group([
        section_head('Free or paid', 'Pick how deep you want to go'),
        group([
            group([h(3, 'Free'), p('$0', 'tm-price-big'), p('forever', 'tm-alt'),
                   lst(['New articles each week. Turn the films, TV shows, and books you already love into writing lessons.',
                        'Each week’s tool, free for two weeks after it’s published'], 'tm-checks'),
                   sc('[tm_substack_signup]')], 'tm-plan'),
            group([h(3, 'Paid'), p('$12', 'tm-price-big'), p('per month, or $50 per year (about $4.17 a month)', 'tm-alt'),
                   lst(['Full access to the Under the Hood Toolkit. Got feedback that your WIP has a specific issue? Search the Toolkit for the exercise that fixes it.',
                        'New articles each week', 'Immediate access to each week’s new tool',
                        'The Plot Doctor Diagnostic, a three-part course to make sure your draft hits every scene it needs',
                        'The Writing Lessons Everywhere community on Substack chat', 'Book club (coming soon)'], 'tm-checks'),
                   buttons(button('Become a paid subscriber', SUBSTACK_SUBSCRIBE, blank=True, cls='tm-btn-blue'))],
                  'tm-plan tm-plan--paid'),
        ], 'tm-plans'),
    ])

    toolkit = panel([
        p('The Under the Hood Toolkit', 'tm-eyebrow'), h(2, 'Every WLE worksheet, searchable by issue'),
        p('If you need to refine your draft but can’t drop thousands of dollars on a book coach or narrative consultant, then Writing Lessons Everywhere is exactly what you need. Become a paid subscriber to access every WLE worksheet in the Under the Hood Toolkit.', 'tm-lede'),
        buttons(button('See the whole database →', TOOLKIT, outline=True, blank=True)),
    ])

    recent = group([section_head('From the newsletter', 'Recent lessons'), sc('[tm_substack_posts count="3"]')])

    about = panel([
        img(IMG('tucker-header.jpg'), 'Tucker May', 'tm-mini-photo'),
        group([h(3, 'About Tucker'),
               p('I’m a working mystery novelist taking the books, shows, and films you already love, finding the gear turning underneath, and handing you the tool. Same method, new source every time.')]),
    ], 'tm-about-mini')

    page('page-wle', 'Writing Lessons Everywhere page', [hero, smt, plans, toolkit, recent, about],
         'Newsletter pitch, Source → Mechanism → Tool example, free vs. paid, Toolkit, and recent posts.')


# ---------------------------------------------------------------- comedy
JOKES = [
    ('In this movie, a man risks everything to save a rock. In Kevin Hart movies, a man risks everything to save The Rock.', 'Project Hail Mary'),
    ('The severance procedure is messed up. The only time you shouldn’t remember what happened at work is the day after the office Christmas party.', 'Severance'),
    ('The salaries for the movie’s stars leaked online. The original was based on a book. The sequel is based on a checkbook.', 'The Devil Wears Prada 2'),
    ('The show is called The White Lotus and the creator is Mike White. I guess he felt “The Mike Lotus” was too on-the-nose.', 'The White Lotus'),
    ('Jordan Peele’s production company lost a bidding war for Weapons. He said, “Us?” and they said, “Nope. Get Out.”', 'Weapons'),
    ('Adam Scott’s character defends his work at Lumon as “mysterious and important,” which is the exact phrase I use to describe my cat.', 'Severance'),
    ('I thought Gosling made a pretty convincing astronaut. Others say his performance lacks gravity.', 'Project Hail Mary'),
    ('Season four is reportedly set in France. It’s titled, The White Lotus: Oops! All Mimes.', 'The White Lotus'),
    ('The sequel’s romantic subplot is so undercooked it might give you salmonella.', 'The Devil Wears Prada 2'),
    ('Director Zach Cregger had a history in sketch comedy before turning to horror films. What a pivot: from doing sketch to being sketch.', 'Weapons'),
    ('Rocky survives a lot in this movie. He beats scissors but ultimately succumbs to paper.', 'Project Hail Mary'),
    ('Some fans are upset it took 20 years for a sequel. At this rate, the third’ll be called “The Devil Is Buried in Prada.”', 'The Devil Wears Prada 2'),
    ('The characters in the show are working on a way to undo severance, effectively reversing a surgical procedure. I’m way ahead of them. I put my appendix back in years ago.', 'Severance'),
    ('The script for Weapons sold for $38 million, which is only slightly more than I paid for the ticket to see it.', 'Weapons'),
    ('Mike White made the show as a COVID project and got a global hit. My COVID project was a sourdough starter that triggered my carbon monoxide detector.', 'The White Lotus'),
]


def comedy():
    hero = group([p('For podcasts and YouTube channels', 'tm-eyebrow'), h(1, 'Comedy Ghostwriting'),
                  p('I write killer jokes for podcasts and YouTube channels looking to increase engagement through humor. Tell me what your episode or video covers, and you’ll get a page of custom jokes and ad throws to pepper into your script in the way that’s most organic to your show.', 'tm-lede'),
                  buttons(button('See packages', '#packages', cls='tm-btn-slate'), button('See samples', '#samples', outline=True))],
                 'tm-hero')

    hire = group([
        p('Why hire me', 'tm-eyebrow'), h(2, 'Trained on the same stages as late night’s best'),
        group([
            group([p('Mee-Ow', 'tm-hire-big'), p('Alum of Northwestern’s storied sketch group. Fellow alums include Seth Meyers, Kristen Schaal, and Julia Louis-Dreyfus.')]),
            group([p('Second City &amp; iO', 'tm-hire-big'), p('Has written for comedy teams at The Second City, iO, and iO West.')]),
            group([p('Late-night jokes', 'tm-hire-big'), p('Trained in late-night joke writing at The Second City and The Comedy Lab.')]),
        ], 'tm-hire-grid'),
    ], 'tm-hire')

    packages = group([
        section_head('Packages', 'Try one, or keep the jokes coming',
                     'Every one-sheet: 10 punch-up jokes and 5 intros, transitions, or ad throws, written for your episode or video.'),
        group([
            package('Single one-sheet', '$250', 'one-time',
                    ['10 punch-up jokes', '5 customized intros, transitions, or ad throws', 'Delivered within 5 days',
                     'First order? Money back if you don’t use a single joke'], PAYPAL, 'Risk-free trial', 'tm-pk--trial'),
            package('Bi-Weekly Retainer', '$450', 'per month · $225 per sheet',
                    ['2 one-sheets per month', 'Topics of your choice', '3-day speedy delivery', 'Cancel anytime'], PAYPAL_BIWEEKLY),
            package('Monthly Retainer', '$850', 'per month · $212.50 per sheet',
                    ['4 one-sheets per month', 'Topics of your choice', '3-day speedy delivery', 'Lowest price per sheet', 'Cancel anytime'],
                    PAYPAL_MONTHLY, 'Best deal', 'tm-pk--best'),
        ], 'tm-pks'),
    ], anchor='packages')

    jokes = group([
        section_head('A taste', 'Lines from real one-sheets', 'A few favorites from the sample sheets. They change every few seconds.'),
        group([group([p(j, 'tm-joke-text'), p(src, 'tm-joke-src')], 'tm-joke') for j, src in JOKES], 'tm-jokes tm-rotator'),
        buttons(button('Show me more →', '#', outline=True, cls='tm-rot-next')),
    ])

    sheets = [('the-white-lotus', 'The White Lotus'), ('severance', 'Severance'), ('project-hail-mary', 'Project Hail Mary'),
              ('the-devil-wears-prada-2', 'The Devil Wears Prada 2'), ('weapons', 'Weapons')]
    samples = group([
        section_head('Samples', 'See full one-sheets', 'Click any sheet to see it full size.'),
        group([img(IMG(f'sample-{k}.jpg'), f'Comedy one-sheet for {t}', caption=t, lightbox=True) for k, t in sheets], 'tm-sheets'),
    ], anchor='samples')

    humor = panel([p('Why humor matters', 'tm-eyebrow'), h(2, 'Funny keeps people watching and listening'),
                   p('A laugh early in an episode or video gives your audience a reason to stay, and a reason to come back next week. Your show already has the opinions and the expertise. A one-sheet adds the punchlines.', 'tm-lede')],
                  'tm-narrow')

    steps = group([section_head('How it works', 'Three steps'),
                   lst(['Choose a package and check out through PayPal.',
                        'At checkout, tell me what your episode or video covers, or any other topic you want jokes about. Retainer clients list each month’s topics when they pay that month’s invoice.',
                        'Get your one-sheet: within 5 days for a single sheet, within 3 days on a retainer.'], 'tm-steps', ordered=True)])

    faq = group([section_head('FAQ', 'Questions'), group([
        details('How long will it take?', 'Single one-sheets arrive within 5 days of your order. Retainer sheets arrive within 3 days.'),
        details('What kind of jokes will it be?', 'Each one-sheet has 10 one- or two-liner jokes, the kind you might hear in a late-night show monologue, plus 5 introductions, transitions, or ad throws customized for your show. It works the same way for podcast episodes and YouTube videos.'),
        details('Would you be willing to write jokes about topics other than TV shows and movies?', 'Yes, absolutely. You can include the subject you’d like jokes about when placing your order.'),
        details('What about refunds?', 'Your first one-sheet is a risk-free trial: if you don’t use any of the jokes in your episode or video, you get your money back. After your first order, one-sheets aren’t refundable. Retainers can be canceled anytime, but payments already made aren’t refunded.'),
        details('Do I need to credit you?', 'You will own and retain all rights to the jokes. You are not required to credit me as a writer, but if you would like to do so it is highly appreciated.'),
    ], 'tm-faqs')])

    contact = panel([p('Questions?', 'tm-eyebrow'), h(2, 'Contact Tucker'), sc('[tm_contact_form topic="Comedy ghostwriting"]')])

    page('page-comedy', 'Comedy Ghostwriting page', [hero, hire, packages, jokes, samples, humor, steps, faq, contact],
         'Packages (single sheet and retainers), credentials, rotating sample jokes, sample sheets, FAQ, and contact form.')


def thank_you():
    def card(name, steps_, badge=None):
        parts = [p(badge, 'tm-pk-badge')] if badge else []
        parts += [h(3, name), lst(steps_, 'tm-steps', ordered=True)]
        return group(parts, 'tm-ty-card')
    page('page-thank-you', 'Thank-you page', [
        group([p('Order received', 'tm-eyebrow'), h(1, 'Thank you!'),
               p('Your payment went through and your order is in. PayPal is emailing your receipt now. Here’s what happens next for the package you chose.', 'tm-lede')], 'tm-hero'),
        group([
            card('Single one-sheet', ['I start writing from the topic you gave at checkout.',
                                      'Your one-sheet arrives at your PayPal email within 5 days.',
                                      'First order? It’s risk-free: if you don’t use any of the jokes in your episode or video, email me for a full refund.'], 'Risk-free trial'),
            card('Bi-Weekly Retainer', ['This month’s sheets are based on the topics you listed at checkout. The first one arrives within 3 days.',
                                        'Each month you’ll receive a new PayPal invoice. List that month’s topics when you pay it.',
                                        'Two sheets per month, each delivered within 3 days. Cancel anytime.']),
            card('Monthly Retainer', ['This month’s sheets are based on the topics you listed at checkout. The first one arrives within 3 days.',
                                      'Each month you’ll receive a new PayPal invoice. List that month’s topics when you pay it.',
                                      'Four sheets per month, each delivered within 3 days. Cancel anytime.'], 'Best deal'),
        ], 'tm-ty-grid'),
        panel([h(2, 'Questions about your order?'),
               p('Email <a href="mailto:tucker@tuckermaybooks.com">tucker@tuckermaybooks.com</a> and I’ll get back to you.', 'tm-lede')]),
        group([
            group([p('While you wait', 'tm-eyebrow'), h(2, 'Writing Lessons Everywhere'),
                   p('My free weekly newsletter: practical writing lessons from the pop culture in the headlines.')]),
            buttons(button('Subscribe free', SUBSTACK_SUBSCRIBE, blank=True, cls='tm-btn-blue')),
        ], 'tm-cross'),
    ], 'Shown after PayPal checkout: what happens next for each package, contact email, and newsletter signup.')


# ---------------------------------------------------------------- youtube
def youtube():
    hero = group([
        group([p('For YouTube channels', 'tm-eyebrow'), h(1, 'YouTube Scripts'),
               p('I specialize in researching and synthesizing complex ideas into compelling videos. Full scripts written from scratch, or rewrites of scripts you already have.', 'tm-lede'),
               buttons(button('Ask about pricing', '#contact-form', cls='tm-btn-slate'), button('See samples', '#samples', outline=True))],
              'tm-hero'),
        panel([p('Any genre. Specializing in', 'tm-eyebrow'), lst(['History', 'Sports', 'Comedy', 'Entertainment'], 'tm-chips')], 'tm-spec'),
    ], 'tm-split')

    offers = group([section_head('What I write', 'Two ways to work together'), group([
        group([group([h(3, 'Full scripts'), p('Quote', 'tm-price')], 'tm-offer-head'),
               p('Researched, structured, and written for your voice and your format, from outline to final draft.')], 'tm-offer'),
        group([group([h(3, 'Rewrites'), p('Quote', 'tm-price')], 'tm-offer-head'),
               p('Already have a script? I’ll tighten the structure, sharpen the hook, and make it land.')], 'tm-offer'),
    ], 'tm-offers')])

    process = group([
        section_head('How it works', 'From first call to final draft'),
        lst(['Intro call: we talk about your channel, your audience, and the video.',
             'Brief: you share the topic, length, tone, and any research or references.',
             'Outline: I send the structure for your sign-off before drafting.',
             'Draft: the full script, researched and written for your voice.',
             'Revisions: as many rounds as it takes. No cap.'], 'tm-steps', ordered=True),
        group([group([p('Pricing', 'tm-fact-title'), p('Contact for a quote')]),
               group([p('Turnaround', 'tm-fact-title'), p('Depends on the length of the project')]),
               group([p('Revisions', 'tm-fact-title'), p('Unlimited')])], 'tm-facts'),
    ])

    def sample_group(name):
        return panel([h(3, name), lst(['<a href="#" target="_blank" rel="noreferrer noopener">[Sample title]</a>',
                                       '<a href="#" target="_blank" rel="noreferrer noopener">[Sample title]</a>'], 'tm-sample-list')])

    samples = group([section_head('Samples', 'Read sample scripts', 'Each sample opens in Google Docs.'),
                     group([sample_group('Explainers / Video Essays'), sample_group('Commentary'),
                            sample_group('Video Listicles')], 'tm-sample-groups')], anchor='samples')

    contact = panel([p('Start a project', 'tm-eyebrow'), h(2, 'Tell me about your channel'),
                     sc('[tm_contact_form topic="YouTube scripts"]')])

    page('page-youtube', 'YouTube Scripts page', [hero, offers, process, samples, contact],
         'Full scripts and rewrites, specialties, process, sample links, and contact form.')


# ---------------------------------------------------------------- other writing
def screenplays():
    page('page-screenplays', 'Screenplays page', [
        group([p('Other writing', 'tm-eyebrow'), h(1, 'Screenplays'),
               p('Feature scripts available to read on request.', 'tm-lede')], 'tm-hero'),
        group([entry_screenplay(), entry_screenplay(), entry_screenplay()], 'tm-entries'),
        panel([p('Request a script', 'tm-eyebrow'), h(2, 'Which one would you like to read?'), sc('[tm_script_request]')]),
    ], 'Screenplay entries with a shared "Request script" form.')


def tv():
    page('page-tv', 'TV Shows page', [
        group([p('Other writing', 'tm-eyebrow'), h(1, 'TV Shows'),
               p('Original pilots and spec scripts. Click any title to read.', 'tm-lede')], 'tm-hero'),
        group([entry_tv('Original pilot'), entry_tv('Spec'), entry_tv('Original pilot')], 'tm-entries'),
    ], 'TV pilot and spec entries with links to read.')


def poetry():
    page('page-poetry', 'Poetry / Short Stories page', [
        group([p('Other writing', 'tm-eyebrow'), h(1, 'Poetry / Short Stories'),
               p('Short fiction and poems, free to read.', 'tm-lede')], 'tm-hero'),
        group([entry_story('Short story', external=True), entry_story('Poem'), entry_story('Short story'),
               entry_story('Poem')], 'tm-entries'),
    ], 'Short stories and poems with links to read.')


# ---------------------------------------------------------------- about, blog, contact, portfolio, privacy
def about():
    bio = ['Tucker May was raised in and around Springfield, Missouri in the heart of the Ozarks. He excelled in theater performance, speech and debate, and public speaking throughout his school years.',
           'He attended Northwestern University in Evanston, Illinois and graduated with a Bachelor of Science in Theater. At Northwestern, he was trained in playwriting and acting. He was a member of the comedic performance groups Northwestern Sketch Television, The Titanic Players, and Mee-Ow.',
           'Since college, he has taken writing classes at Second City in Chicago, iO in Chicago, iO West in Los Angeles, The Writer’s Workshop and with TV Writer Janae Bakken.',
           'He has written two novels, <em>Death of a Billionaire</em> and <em>The Lemon House Murders</em>, as well as multiple screenplays. His newest novel, <em>The Last Dead Guy in Hell</em> is due out in 2027.']
    page('page-about', 'About page', [
        group([img(IMG('tucker-about.jpg'), 'Tucker May', 'tm-portrait'),
               group([p('About', 'tm-eyebrow'), h(1, 'Tucker May'), group([p(x) for x in bio], 'tm-bio')])], 'tm-about'),
        group([section_head('Where to next', 'Find your way in'), group([
            p(f'<a href="{URL("/novels/")}"><strong>The Novels</strong> Mysteries by Tucker May</a>', 'tm-jump tm-jump--pine'),
            p(f'<a href="{URL("/writing-lessons-everywhere/")}"><strong>Writing Lessons Everywhere</strong> A weekly newsletter for writers</a>', 'tm-jump tm-jump--navy'),
            p(f'<a href="{URL(COMEDY)}"><strong>Comedy Ghostwriting</strong> Jokes for podcasts and YouTube channels</a>', 'tm-jump tm-jump--slate'),
        ], 'tm-jumps')]),
    ], 'Bio with photo and links to the three main sections.')


def blog():
    page('page-blog', 'Blog page', [
        group([p('Writing Lessons Everywhere', 'tm-eyebrow'), h(1, 'Blog'),
               p('The latest posts from Writing Lessons Everywhere, pulled from Substack automatically.', 'tm-lede')], 'tm-hero'),
        sc('[tm_substack_posts layout="cards" count="5" more="5"]'),
    ], 'Latest Substack posts with cover images and a Load more button.')


def contact():
    page('page-contact', 'Contact page', [
        group([p('Contact', 'tm-eyebrow'), h(1, 'Get in touch'),
               p('Questions about the books, the newsletter, or working together. I’ll get back to you by email.', 'tm-lede')], 'tm-hero'),
        panel([sc('[tm_contact_form]')]),
        p(f'<a href="{IG}" target="_blank" rel="noreferrer noopener">Instagram</a> <a href="{BSKY}" target="_blank" rel="noreferrer noopener">Bluesky</a> <a href="{FB}" target="_blank" rel="noreferrer noopener">Facebook</a>', 'tm-social-row'),
    ], 'Contact form with topic dropdown and social links.')


def portfolio():
    items = [('pine', '/novels/', 'Novels', 'Death of a Billionaire, The Lemon House Murders, and The Last Dead Guy in Hell'),
             ('ink', '/screenplays/', 'Screenplays', 'Feature scripts, available on request'),
             ('ink', '/tv-shows/', 'TV Shows', 'Original pilots and spec scripts to read'),
             ('ink', '/poetry-prose/', 'Poetry / Short Stories', 'Short fiction and poems to read'),
             ('ink', '/sketch-comedy/', 'Sketch Comedy Sample Packet', 'A sample packet of sketch comedy writing'),
             ('slate', '/youtube-scripts/', 'YouTube script samples', 'Explainers, commentary, and video listicles'),
             ('slate', COMEDY, 'Comedy ghostwriting', 'Sample joke sheets for podcasts and YouTube channels'),
             ('navy', '/writing-lessons-everywhere/', 'Writing Lessons Everywhere', 'Weekly writing lessons on Substack')]
    page('page-portfolio', 'Portfolio page', [
        group([p('Portfolio', 'tm-eyebrow'), h(1, 'Everything I’ve written'),
               p('Novels, scripts, jokes, and essays in one place. Pick a section.', 'tm-lede')], 'tm-hero'),
        group([p(f'<a href="{URL(path)}"><strong>{t}</strong> {d}</a>', f'tm-port tm-port--{c}') for c, path, t, d in items],
              'tm-port-grid'),
    ], 'Hub page linking every sample section (keeps the old /portfolio/ link working).')


def privacy():
    page('page-privacy', 'Privacy Policy page', [
        group([p('Legal', 'tm-eyebrow'), h(1, 'Privacy Policy'), p('Last updated: [date]', 'tm-lede')], 'tm-hero'),
        panel([
            p('Draft for Tucker to review before launch. Delete this note when it’s final.', 'tm-draft-note'),
            h(2, 'Who I am'),
            p('This website, tuckermay.com, is run by Tucker May, an author based in Pasadena, California. Questions about this policy can go to Tucker@TuckerMayBooks.com.'),
            h(2, 'What I collect'),
            lst(['<strong>Contact and script-request forms:</strong> your name, email address, the topic you choose, and your message. I use these only to reply to you.',
                 '<strong>Book release updates:</strong> your email address, stored by MailerLite, the service that sends the emails.',
                 '<strong>Writing Lessons Everywhere:</strong> when you subscribe, your email address goes to Substack. Substack’s privacy policy covers that subscription.',
                 '<strong>Basic site data:</strong> like most websites, the hosting server records technical information such as IP address and browser type for security and troubleshooting.']),
            h(2, 'Third-party services'),
            p('Some links and features hand you off to other companies, each with its own privacy policy: Amazon (book purchases), PayPal (one-sheet payments), Substack (newsletter), MailerLite (release emails), Google Docs (sample scripts), and Instagram, Bluesky, and Facebook (social links).'),
            h(2, 'Cookies'),
            p('[List any cookies the site uses, for example from an analytics tool. If there’s no analytics, say so here.]'),
            h(2, 'What I don’t do'),
            p('I don’t sell or rent your personal information, and I don’t share it except with the services listed above that are needed to run the site.'),
            h(2, 'Your choices'),
            p('You can unsubscribe from any email with the link at the bottom of it. To see, correct, or delete the information I hold about you, email Tucker@TuckerMayBooks.com.'),
            h(2, 'Changes'),
            p('If this policy changes, I’ll update it here and change the date at the top.'),
        ], 'tm-legal'),
    ], 'Privacy policy draft.')


# ---------------------------------------------------------------- insertable sections
def sections():
    write('entry-screenplay', 'Screenplay entry', entry_screenplay(),
          desc='Title, logline, summary, and a Request script button that fills in the request form.')
    write('entry-tv', 'TV show entry', entry_tv(), desc='Pilot or spec label, title, logline, and a Read the script link.')
    write('entry-story', 'Story or poem entry', entry_story(), desc='Label, title, and a Read link.')
    write('entry-story-external', 'Story or poem entry (published elsewhere)', entry_story(external=True),
          desc='Label, title, where it was published, and a link to read it there.')
    write('review-quote', 'Review quote', review(), desc='Five stars, a quote, and the reviewer.')


if __name__ == '__main__':
    os.makedirs(OUT, exist_ok=True)
    for f in os.listdir(OUT):
        if f.endswith('.php'):
            os.remove(os.path.join(OUT, f))
    header(); footer(); home(); novels(); wle(); comedy(); youtube()
    screenplays(); tv(); poetry(); about(); blog(); contact(); portfolio(); privacy(); thank_you(); sections()
    print('\n'.join(sorted(os.listdir(OUT))))
