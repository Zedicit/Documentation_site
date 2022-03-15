# Documentation for this site

[Home Page](HomePage.md)

# Information

[Markdown Cheat Sheet](information/markdown-cheat-sheet.md)

[Terms to search:](./information/terms_to_search.md)

[Purpose:](./information/purpose.md)

[Plan:](./information/plan.md)

[Planned Features:](information/planned_features.md)

# Overview

[Why Markdown:](Overview/why_markdown.md)

- [Step 1: we need a server](Overview/step1_we_need_a_server.md)
  - [Sidenote: SSH key and your server]()

[Web Server Choice:]()

- [NGINX vs. Apache]()
- [Apache Overview]()
- [NGINX overview]()
- [Apache Handling Connections]()
- [NGINX Handling Connections]()
- [Conclusion:]()

# Making of Site

1. [setting up the web server]()
   1. [changing the default setings within apache config file]()
   2. [ensure that php is installed and working correctly]()
2. [integrating project, mdbook for markdown conversion]()
   1. [downloading mdbook from GitHub]()
   2. [initializing mdbook for site]()
   3. [editing the basic SUMMARY.md file]()
3. [creating a GitHub repository that will be displayed on site]()
   1. [creating a repository on GitHub and cloning it to web site]()
      1. [setting the git committer inforamtion for commitss from the website]()
   2. [commit current test files to the repository]()
      1. [creating GitHub authentication token]()
   3. [Create a Webhook for GitHub repository]()
   4. [write temp code to test handle data from webhook]()
      1. [fixing permission denied error]()
      2. [fixing message response error for php StdClass cannot be converted into string]()
4. [coding mdbook update from push event]()
   1. [doing something with the webhook message]()
   2. [updating book with a push event to page]()
   3. [changing code to determine if normal GitHub webhook json push event]()
   4. [replacing GitHub event handler code]()
5. [backup of website]()
   1. [downloading entire diredctory from server]()