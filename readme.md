#### Product parser

Reads an XML file and saves the products in database.

The file must have the following structure:

``<?xml version="1.0" encoding="utf-8"?>
  <feed xmlns="http://www.w3.org/2005/Atom">
      <item>
          <title>Product title</title>
          <link>Product link</link>
      </item>
  </feed>
``

To execute it, run

`bin/console parse-products {filepath}`



