# Operations

TYPO3 extension to manage and display firefighter operations. Organize data in backend and use different views to show them on a TYPO3 website.

1. Install the extension in Extension Manager of TYPO3 or use composer for installing the extension.
2. Include the static TyposScript of the extension to your TypoScript template or add it to the TypoScript in your site package (theme extension)
3. Create pages for:
    * different list views (operations, vehicles, resources, statistics, map view)
    *  according to those list views you should set up the detail views, as a subpage of the page with the list view
    * create operation content elements on that pages, choose the plugin type
    * at least one sysfolder for operation data (operations, resources, categories, …)
4. **Important!** Set configuration constants in the TYPO3 Constant Editor or directly in constant field of a TypoScript template or whereever you want to define your project constants. 
5. There is also a plugin to view operations statistic. Create new content element and choose the "Operations statistic" plugin.

You find a more detailed documentation here: https://extensions.typo3.org/extension/operations
