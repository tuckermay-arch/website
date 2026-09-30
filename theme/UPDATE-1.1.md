# Update 1.1: Comedy Ghostwriting and the thank-you page

About 15 minutes. Only the pages named below change; every other page stays exactly as you left it.

You'll need these files (attached in the chat):
- `tuckermay.zip` (theme version 1.1)
- `page-comedy.txt`, `page-home.txt`, `page-thank-you.txt`, `page-portfolio.txt`

**How to paste a page** (you'll do this four times):
open the page → **⋮** (top right) → **Code editor** → click in the big text box → select all (Ctrl/Cmd + A) → paste → **Exit code editor** → **Save**.
If anything looks off, **⋮ → Revisions** brings back the previous version.

## 1. Upload the new theme
1. **Appearance → Themes → Add New Theme → Upload Theme.**
2. Choose `tuckermay.zip` → **Install Now**.
3. WordPress says the theme is already installed: click **Replace installed with uploaded**.

## 2. Comedy page: new content, name, and address
1. **Pages → Comedy One-Sheets → Edit.**
2. Paste `page-comedy.txt` (see "How to paste a page" above).
3. Change the title at the top to **Comedy Ghostwriting**.
4. In the right sidebar, under **Page**, click the address (**Link** / **Slug**) and change `comedy-one-sheets` to `comedy-ghostwriting`.
5. **Save.**

Old links to `/comedy-one-sheets/` now forward to `/comedy-ghostwriting/` automatically.

## 3. Homepage
**Pages → Home → Edit**, paste `page-home.txt`, **Save**.
This replaces the whole homepage with the current design, including your book descriptions. If you'd changed anything else on the homepage, tell Claude first so it can be included.

## 4. Portfolio
**Pages → Portfolio → Edit**, paste `page-portfolio.txt`, **Save**.
Includes the Sketch Comedy Sample Packet card and the renamed Comedy ghostwriting card.

## 5. Thank-you page (new)
1. **Pages → Add New Page.** Close the pattern chooser if it appears.
2. Title: **Thank You**.
3. Paste `page-thank-you.txt` using the code editor.
4. In the right sidebar: set **Template** to **Designed page (no title)**, and set the address (**Slug**) to `thank-you`.
5. **Publish.**

The page is kept out of Google results automatically, and it isn't in the menu.

## 6. Menu
The theme's menu now says **Comedy Ghostwriting** and lists **Sketch Comedy** under Other Writing.
1. **Appearance → Editor → Patterns → Template Parts → Header.**
2. If the menu already shows "Comedy Ghostwriting", you're done.
3. If it still says "Comedy One-Sheets" (because you edited the header earlier), open the **⋮** menu on the Header and choose **Reset** (it may say **Clear customizations**). This loads the theme's updated header.

## 7. Point PayPal at the thank-you page
Do this for each of the three buttons (single sheet, Bi-Weekly Retainer, Monthly Retainer):
1. Log in to PayPal → **Pay & Get Paid → PayPal buttons** (or **Payment links and buttons**).
2. Open the button → **Edit**.
3. Find the after-payment setting (usually **Customize after payment** or **Redirect to website**) and enter `https://tuckermay.com/thank-you/`.
4. **Save.**

Then make a test purchase (or ask PayPal support for a test mode) to confirm buyers land on the thank-you page.

## Check
- tuckermay.com: the Comedy card says **Comedy Ghostwriting**, and its title links to the new page.
- tuckermay.com/comedy-one-sheets/ forwards to /comedy-ghostwriting/.
- On the Comedy page, the jokes change every few seconds and each sample sheet opens full size when clicked.
