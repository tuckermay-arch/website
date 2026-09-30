# Updating the theme (version 1.2)

About 5 minutes. No pasting.

## 1. Upload the theme
1. **Appearance → Themes → Add New Theme → Upload Theme.**
2. Choose `tuckermay.zip` → **Install Now**.
3. WordPress says the theme is already installed. Click **Replace installed with uploaded**. (If you click anything else, the old version stays.)

## 2. Confirm the version
Go to **Appearance → Tucker May Settings**. Under the heading it should say **Theme version 1.2.0**. If it doesn't, repeat step 1.

## 3. Click "Apply update 1.1"
It's the first box on that screen. One click:
- gives the Comedy page its new design, renames it **Comedy Ghostwriting**, and moves it to `/comedy-ghostwriting/` (old links forward automatically);
- updates the Home and Portfolio pages;
- creates the Thank You page at `/thank-you/`;
- resets the header so the menu shows Comedy Ghostwriting and Sketch Comedy.

Nothing else changes. The previous version of each changed page stays in **⋮ → Revisions**.

## 4. If a page still looks old
Clear the cache: in the WordPress top bar, or in HostGator's cPanel under **Caching**. Then reload with Ctrl/Cmd + Shift + R.

## 5. PayPal (the only manual step)
For each of the three buttons (single sheet, Bi-Weekly Retainer, Monthly Retainer):
1. Log in to PayPal → **Pay & Get Paid → PayPal buttons** (or **Payment links and buttons**).
2. Open the button → **Edit**.
3. Find the after-payment setting (usually **Customize after payment** or **Redirect to website**) and enter `https://tuckermay.com/thank-you/`.
4. **Save**.

Then make one test purchase to confirm buyers land on the thank-you page.
