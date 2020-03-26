# Instructions for OOP test

1. You must create a class extending FeedParserBase following Object Oriented Programming Best Practices
2. This class must load the feed products.xml throught method 'parse'. Feed location must be set in var $_strFeedUrl.
3. Your class must log start and end of parsing process and also every item parsed with method notify in class 'InfoLogger'.
4. Your class must log any error that might happen trough notify method in class 'ErrorLogger'
5. Class must log these errors: feed not found, empty feed, or incorrect item (empty title or link)
6. Class must have proper exception handling
7. Your code should be able to be executed via CLI (php ProductsParsing.php)
8. Your class should return an array of Product objects (Product class and a proper namespace must be created) with name, url, ID, and date (in Y-m-d H:i:s)
9. In all the exercise, you should try to follow PSR-0, PSR-1 and PSR-2
10. Generally speaking, the more decoupled your code, the better, so do not hesitate to create as many classes and namespaces as you wish


```xml
<item>
	<title>Marqués de Riscal Vino Tinto Reserva D.O. Rioja</title>
	<link>https://www.ulabox.com/producto/marques-de-riscal-vino-tinto-reserva-d-o-rioja/7408</link>
	<pubDate>Mon, 10 Sep 2011 17:20:00 +0100</pubDate>
</item>
```

And Product object should look like

name: Marqués de Riscal Vino Tinto Reserva D.O. Rioja
id: 7408
date: 2011-09-10 17:20:00
url: https://www.ulabox.com/producto/marques-de-riscal-vino-tinto-reserva-d-o-rioja/7408

