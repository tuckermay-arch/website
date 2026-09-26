# Installing the Tucker May theme

About 20 minutes, start to finish. Everything happens in your WordPress dashboard (yoursite.com/wp-admin).

## Before you start

1. **Back up the site.** In HostGator's cPanel, open **Backup** or **Site Backup & Restore** and download a full backup. If anything goes wrong, you can restore it.
2. **Check your WordPress version.** Go to **Dashboard → Updates**. The theme needs WordPress 6.6 or newer. If you're older, click **Update to version …** first.

## 1. Upload and turn on the theme

1. **Appearance → Themes → Add New Theme → Upload Theme.**
2. Choose `tuckermay.zip`, click **Install Now**, then **Activate**.

Your old pages will look unstyled for a moment. That's expected until step 3.

## 2. Connect your services

Go to **Appearance → Tucker May Settings**.

- **Substack address:** already set to `https://tuckermaymysteries.substack.com`. Leave it.
- **MailerLite form:** this powers the "Notify me" boxes for *The Last Dead Guy in Hell*.
  1. In MailerLite, go to **Forms → Embedded forms** and create a form (or open your existing one) that adds people to your new-book group.
  2. Open **Overview → Embed form → HTML code** and copy all of it.
  3. Paste it into the box. The theme keeps only the address it needs.
- **Send contact forms to:** already `Tucker@TuckerMayBooks.com`.

Click **Save Changes**. The page should say **Connected** under MailerLite.

## 3. Create the pages

Further down the same settings screen is **Set up the site's pages**. The table shows which pages already exist on your site (probably Novels, Portfolio, and Poetry / Prose).

1. Tick **Also replace the content of pages that already exist with the new design.** Old content isn't deleted; it stays in each page's **Revisions**.
2. Click **Set up pages**.

This creates every page, fills each one with its design, makes **Home** your front page, and sets the Privacy Policy page. Visit your site: it should now match the mockups.

**If you had an old homepage page:** it's no longer the front page but still exists. Delete it or leave it as a draft.

## 4. Fill in the placeholders

Anything in [square brackets] is a spot for your content. Open the page (**Pages → the page → Edit**), click the text, and type.

| Page | What to fill in |
|---|---|
| Novels | Three review quotes per book: the quote and "Reviewer, source" |
| YouTube Scripts | Sample titles, and each one's Google Docs link (select the text → link icon) |
| Screenplays | Genre, title, logline, summary for each script |
| TV Shows | Title, logline, and the script link on each "Read the script" button |
| Poetry / Short Stories | Title and link for each piece; publication name on the external one |
| Privacy Policy | The date, the Cookies section, then delete the gray draft note |

## 5. Test the forms (important)

HostGator's email sometimes lands in spam or doesn't send at all.

1. Log out (or use a private browser window) and send yourself a message from the **Contact** page.
2. If it doesn't arrive within a few minutes (check spam too), install the free **WP Mail SMTP** plugin and connect it to your email provider. That fixes delivery for every form on the site.
3. Also test **Notify me** once and confirm the address shows up in MailerLite.

## Everyday editing

**Change text or images:** open the page, click, and type. To swap an image, click it → **Replace**.

**Add a new screenplay, TV script, or story:**
1. Open the page and click the **+** at the point where you want it.
2. Choose **Patterns → Tucker May: sections**, then **Screenplay entry**, **TV show entry**, **Story or poem entry**, or **Story or poem entry (published elsewhere)**.
3. Type over the placeholders and paste in the link.

You can also select an existing entry, click **⋮ → Duplicate**, and edit the copy. On Screenplays, the "Request script" button works for new entries automatically; there's nothing to set up.

**Add a review quote:** click **+ → Patterns → Review quote**, or duplicate an existing one.

**Change the header or footer** (menu, photo, subheader, social links): go to **Appearance → Editor → Patterns**, and open **Header** or **Footer** under Template Parts.

**Change the menu:** in the header, click the menu and edit the links like text.

**Rebuild a page from scratch:** create a new page, pick **Tucker May: full pages** from the pattern chooser, and set the template to **Designed page (no title)** in the page settings sidebar.

## What updates by itself

- **Recent Substack posts** (homepage, Writing Lessons Everywhere page, Blog) refresh within an hour of each new post.
- **Footer year** changes every January.
