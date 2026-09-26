# tuckermay.com rebuild: content and decisions

## Platform
- WordPress on HostGator, block editor. Deliverable: custom block theme (.zip), user-editable sections.
- Email: MailerLite in use. Substack is the primary list.
- Keep existing URLs: /novels/, /portfolio/, /poetry-prose/ (redirect if slugs change).

## Visual direction
- Palette: Concrete (cool gray #E6E7E3, charcoal #1A1C1E, pine #0E6B5C). No clay red. Scripts card: slate #34506E. Books card: pine #0E6B5C, with the two published covers in the heading band.
- Writing Lessons Everywhere card uses its own brand: navy #052E49, cream #FAF8EF, blue #2D99D1, logo in the card head.
- Source images: design/assets/src/ (from Drive: My Drive > Author Business > Website images). Profile photo: fiverr-profile-photo.jpg (1000x1000).
- Brand logo: T|M circle mark + "Tucker May Books" (design/assets/tm-logo-full.png, tm-mark.png). Header uses the mark only. Need a transparent PNG or SVG original for the build.
- Fonts: Geist (headings, body) + Geist Mono (labels).
- Layout: compact header, three freestanding cards with colored heading bands.

## Homepage
- Header: logo mark, square photo, "Tucker May", subheader "Novels · Comedy Writing · A Community for Writers" (Tucker is a peer/community moderator, not a teacher).
- Three columns, priority order: Books > Writing Lessons Everywhere > Comedy One-Sheets. Books card is wider (1.35fr 1fr 1fr) and has no visible title (covers act as heading).

## Books (Amazon only)
- Death of a Billionaire: hardcover, paperback, Kindle (KDP Select), audiobook. https://a.co/d/0a47KAUl (Substack uses https://a.co/d/0j6DiCPy)
- The Lemon House Murders: hardcover, paperback, Kindle. https://a.co/d/05ZV8bDo (Substack uses https://a.co/d/0gaaofTb)
- Upcoming: The Last Dead Guy in Hell. Cover exists, no date. Compact "Coming soon" panel in the Books card (cover smaller than the published books).
- Hovering a published cover shows its plot summary below the buy buttons (touch devices show both). Short and long descriptions are in the mockups (homepage-mockup.html, pages-mockup.html). Email signup goes to MailerLite, then a second step offers a Writing Lessons Everywhere subscription (Substack confirms by email). Chosen over checkbox + manual import.
- One Novels page for all three books (details after homepage is final).
- Review blurbs on the Novels page only, user-editable.

## Writing Lessons Everywhere (Substack: tuckermaymysteries.substack.com)
- Weekly. Format: Source → Mechanism → Tool.
- Free: weekly articles. Paid: Under the Hood Toolkit (https://writinglessonseverywhere.netlify.app/), weekly tools immediately, Plot Doctor Diagnostic course, community.
- Pitch: "If you need to refine your draft but can't drop thousands of dollars on a book coach or narrative consultant, then Writing Lessons Everywhere is exactly what you need."
- Embed signup; show 2 recent posts from RSS on the homepage.
- Homepage card copy after the signup: "If you need to refine your draft... exactly what you need." + "Become a paid subscriber to access every WLE worksheet in the Under the Hood Toolkit." + link to the Toolkit database.

## Navigation
- Books · Writing Lessons Everywhere · Comedy One-Sheets · YouTube Scripts · Other Writing (dropdown: Screenplays, TV Shows, Poetry / Short Stories) · Blog · About · Contact. Menu sits on its own row under the name.

## Inner pages (mockups: design/pages-mockup.html)
- Novels: two descriptions per book (short for homepage hover, long for this page); 3 review quotes per book (editable spots; Tucker adds them in WordPress); Last Dead Guy teaser: "When a creative loner’s best friend goes missing, the quest to find him uncovers a conspiracy that threatens all of existence as we know it."; audiobook uses the same Amazon link; Coming Soon at the bottom; WLE cross-sell.
- WLE: paid $12/month or $50/year. Paid and free both use the Substack subscribe link. Community = Substack chat; book club coming soon. Sample post: Toy Story 4 (https://tuckermaymysteries.substack.com/p/toy-story-4-writing-lesson; published text pasted in chat: Sell the Want / Hide the Need in Plain Sight / Honor the Want Before Subverting; tool = want/need worksheet in the Toolkit).
- Comedy One-Sheets: example PDFs from Drive (Author Business > Online Content > Podcast One-Sheets): The White Lotus, Severance, Project Hail Mary, The Devil Wears Prada 2, Weapons (design/assets/src/one-sheets/). Keep the existing FAQ. "Studies prove" line rewritten without the claim.
- Comedy: "Why hire me" is a prominent slate band right after the hero (credentials stay Mee-Ow, Second City/iO/iO West, Comedy Lab; NSTV and Titanic Players not added).
- Coming Soon panels keep "Coming soon" (no year).
- YouTube Scripts: full scripts or rewrites; any genre, specializing in history, sports, comedy, and entertainment channels; "I specialize in researching and synthesizing complex ideas into compelling videos"; process intro call > brief > outline > draft > unlimited revisions; contact for pricing; turnaround depends on length; samples (Google Docs links) grouped Explainers / Video Essays, Commentary, Video Listicles.
- Other Writing: each is its own page. Screenplays (3): title, logline, brief summary, Request script (form). TV Shows (pilots + specs): title, logline, link to read. Poetry / Short Stories: link to read each; one links to an external publication.
- About: bio pasted in chat (Springfield MO, Northwestern BS Theater, NSTV / Titanic Players / Mee-Ow, classes at Second City, iO, iO West, The Writer's Workshop, Janae Bakken; Last Dead Guy due 2027). About photo: design/assets/src/about-photo.jpg (1000x1000). About page only; the header keeps the Fiverr photo.
- Blog: title + subtitle + Substack cover image, latest 5, Load more.
- Contact: form adds "What's this about?" dropdown.
- WLE page "About Tucker" uses the post sign-off line.
- Adding samples later must be easy (Screenplays, TV Shows, Poetry / Short Stories): each entry is a reusable block pattern ("Screenplay entry", "TV show entry", "Story or poem entry") inserted from the + menu, or duplicated from an existing entry. Screenplays use ONE shared request form at the bottom; each "Request script" button fills in that entry's title automatically, so a new screenplay needs no form setup.
- /portfolio/ stays as a hub page (not in the menu) linking to every sample section: Novels, Screenplays, TV Shows, Poetry / Short Stories, YouTube samples, Comedy one-sheets, WLE. Keeps old links working.
- Privacy Policy page, linked in the footer only. Draft in pages-mockup.html; Tucker to review (cookies section depends on analytics choice).

## Comedy one-sheets (homepage card is one-sheets only, for movie and TV podcasts)
- YouTube scriptwriting moves to its own page (not on the homepage). Full scripts: contact for pricing.
- Comedy one-sheet: $250, PayPal https://www.paypal.com/ncp/payment/ZWBQS9N9BLE6G. 10 one/two-liner jokes + 5 intros/transitions/ad throws. 5-day delivery. Client owns rights; credit optional. No refunds.
- Credentials: Northwestern Mee-Ow alum; wrote for comedy teams at The Second City, iO, iO West; late-night joke training at The Second City and The Comedy Lab.
- All work confidential. Portfolio of PDF samples, user-editable.
- Contact form: name, email, message. Plugin OK (WPForms Lite). Delivers to Tucker@TuckerMayBooks.com.
- One-sheet topic is collected on the PayPal checkout page.

## About
- Northwestern graduate. Lives in Pasadena with his wife and their cat, Principal Spittle.

## Socials
- Bluesky: https://bsky.app/profile/tuckermaymysteries.bsky.social
- Instagram: https://www.instagram.com/tuckermaymysteries/
- Facebook: https://www.facebook.com/people/Tucker-May-Mysteries/61556491591135/

## Success targets (monthly)
- 10 Substack subscribers, 5 book sales, 5 ghostwriting inquiries.
