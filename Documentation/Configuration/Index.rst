.. include:: ../Includes.txt


.. _configuration:

=============
Configuration
=============


Include static TypoScript
=========================

The extension come with some TypoScript which needs to be included.

#. Select the root page of your site.

#. Switch to the **Template module** and select *Info/Modify*.

#. Press the link **Edit the whole template record** and switch to the tab *Includes*.

#. Select **Operations (operations)** at the field *Include static (from extensions):*

.. figure:: ../Images/IncludeTs.png
   :class: with-shadow
   :alt: Include static TypoScript

   Include static TypoScript



Typical Example
===============

- Do we need to include a static template?
- For example add a code snippet with comments

Minimal example of TypoScript:

- Code-blocks have support for syntax highlighting
- Use any supported language

.. code-block:: typoscript

   plugin.tx_myextension.settings {
      # configure basic email settings
      email {
         subject = Some subject
         from = someemail@domain.de
      }
   }

.. _configuration-typoscript:

TypoScript Reference
====================

Possible subsections: Reference of TypoScript options.
The construct below show the recommended structure for
TypoScript properties listing and description.

When detailing data types or standard TypoScript
features, don't hesitate to cross-link to the TypoScript
Reference as shown below.


See `Hyperlinks & Cross-Referencing <https://docs.typo3.org/typo3cms/HowToDocument/WritingReST/Hyperlinks.html>`
for information about how to use cross-references.

See the :file:`Settings.cgf` file for the declaration of cross-linking keys.
You can add more keys besides tsref.


