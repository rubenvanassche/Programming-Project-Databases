<?php		
		/*Stats::addContinent("Europe");
		Stats::addCompetition("World Cup");

		Stats::addCountry("Belgium", "Europe", "be");
		Stats::addCoach("Marc Wilmots");
		Stats::addTeam("Belgium", "Belgium", "Marc Wilmots", 500);
		
		Stats::addCountry("Russia", "Europe", "ru");
		Stats::addCoach("Fabio Capello");
		Stats::addTeam("Russia", "Russia", "Fabio Capello", 450);
		
		Stats::addTeamPerCompetition("Belgium", "World Cup");
		Stats::addTeamPerCompetition("Russia", "World Cup");
		Stats::addMatch("Belgium", "Russia", "World Cup", "2014-01-22");
		
		Stats::addPlayerUnique("Vincent Kompany", 0);
		Stats::addPlayerPerTeam("Vincent Kompany", "Belgium");
		
		Stats::addPlayerUnique("Nacer Chadli", 0);
		Stats::addPlayerPerTeam("Nacer Chadli", "Belgium");
		
		Stats::addPlayerUnique("Thibaut Courtois", 0);
		Stats::addPlayerPerTeam("Thibaut Courtois", "Belgium");
		
		Stats::addPlayerUnique("Koen Casteels", 0);
		Stats::addPlayerPerTeam("Koen Casteels", "Belgium");
		
		Stats::addPlayerUnique("Toby Alderweireld", 0);
		Stats::addPlayerPerTeam("Toby Alderweireld", "Belgium");
		
		Stats::addPlayerUnique("Daniel Van Buyten", 0);
		Stats::addPlayerPerTeam("Daniel Van Buyten", "Belgium");
		
		Stats::addPlayerUnique("Simon Mignolet", 0);
		Stats::addPlayerPerTeam("Simon Mignolet", "Belgium");
		
		Stats::addPlayerUnique("Jan Vertonghen", 0);
		Stats::addPlayerPerTeam("Jan Vertonghen", "Belgium");
		
		Stats::addPlayerUnique("Sébastien Pocognoli", 0);
		Stats::addPlayerPerTeam("Sébastien Pocognoli", "Belgium");
		
		Stats::addPlayerUnique("Anthony Vanden Borre", 0);
		Stats::addPlayerPerTeam("Anthony Vanden Borre", "Belgium");
		
		Stats::addPlayerUnique("Nicolas Lombaerts", 0);
		Stats::addPlayerPerTeam("Nicolas Lombaerts", "Belgium");
		
		Stats::addPlayerUnique("Laurent Ciman", 0);
		Stats::addPlayerPerTeam("Laurent Ciman", "Belgium");
		
		Stats::addPlayerUnique("Axel Witsel", 0);
		Stats::addPlayerPerTeam("Axel Witsel", "Belgium");
		
		Stats::addPlayerUnique("Marouane Fellaini", 0);
		Stats::addPlayerPerTeam("Marouane Fellaini", "Belgium");
		
		Stats::addPlayerUnique("Kevin Mirallas", 0);
		Stats::addPlayerPerTeam("Kevin Mirallas", "Belgium");
		
		Stats::addPlayerUnique("Radja Nainggolan", 0);
		Stats::addPlayerPerTeam("Radja Nainggolan", "Belgium");
		
		Stats::addPlayerUnique("Dries Mertens", 0);
		Stats::addPlayerPerTeam("Dries Mertens", "Belgium");
		
		Stats::addPlayerUnique("Timmy Simons", 0);
		Stats::addPlayerPerTeam("Timmy Simons", "Belgium");
		
		Stats::addPlayerUnique("Mousa Dembélé", 0);
		Stats::addPlayerPerTeam("Mousa Dembélé", "Belgium");
		
		Stats::addPlayerUnique("Christian Benteke", 0);
		Stats::addPlayerPerTeam("Christian Benteke", "Belgium");
		
		Stats::addPlayerUnique("Romelu Lukaku", 0);
		Stats::addPlayerPerTeam("Romelu Lukaku", "Belgium");
		
		// RUSSIAN PLAYERS
		Stats::addPlayerUnique("Igor Denisov", 0);
		Stats::addPlayerPerTeam("Igor Denisov", "Russia");
		
		Stats::addPlayerUnique("Igor Akinfeev", 0);
		Stats::addPlayerPerTeam("Igor Akinfeev", "Russia");
		
		Stats::addPlayerUnique("Yuri Lodygin", 0);
		Stats::addPlayerPerTeam("Yuri Lodygin", "Russia");
		
		Stats::addPlayerUnique("Sergey Ryzhikov", 0);
		Stats::addPlayerPerTeam("Sergey Ryzhikov", "Russia");
		
		Stats::addPlayerUnique("Sergei Ignashevich", 0);
		Stats::addPlayerPerTeam("Sergei Ignashevich", "Russia");
		
		Stats::addPlayerUnique("Vasili Berezutski", 0);
		Stats::addPlayerPerTeam("Vasili Berezutski", "Russia");
		
		Stats::addPlayerUnique("Dmitri Kombarov", 0);
		Stats::addPlayerPerTeam("Dmitri Kombarov", "Russia");
		
		Stats::addPlayerUnique("Andrey Yeshchenko", 0);
		Stats::addPlayerPerTeam("Andrey Yeshchenko", "Russia");
		
		Stats::addPlayerUnique("Aleksei Kozlov", 0);
		Stats::addPlayerPerTeam("Aleksei Kozlov", "Russia");
		
		Stats::addPlayerUnique("Vladimir Granat", 0);
		Stats::addPlayerPerTeam("Vladimir Granat", "Russia");
		
		Stats::addPlayerUnique("Georgi Schennikov", 0);
		Stats::addPlayerPerTeam("Georgi Schennikov", "Russia");
		
		Stats::addPlayerUnique("Yevgeni Makeyev", 0);
		Stats::addPlayerPerTeam("Yevgeni Makeyev", "Russia");
		
		Stats::addPlayerUnique("Maksim Belyayev", 0);
		Stats::addPlayerPerTeam("Maksim Belyayev", "Russia");
		
		Stats::addPlayerUnique("Yuri Zhirkov", 0);
		Stats::addPlayerPerTeam("Yuri Zhirkov", "Russia");
		
		Stats::addPlayerUnique("Roman Shirokov", 0);
		Stats::addPlayerPerTeam("Roman Shirokov", "Russia");
		
		Stats::addPlayerUnique("Alan Dzagoev", 0);
		Stats::addPlayerPerTeam("Alan Dzagoev", "Russia");
		
		Stats::addPlayerUnique("Denis Glushakov", 0);
		Stats::addPlayerPerTeam("Denis Glushakov", "Russia");
		
		Stats::addPlayerUnique("Viktor Fayzulin", 0);
		Stats::addPlayerPerTeam("Viktor Fayzulin", "Russia");
		
		Stats::addPlayerUnique("Aleksandr Samedov", 0);
		Stats::addPlayerPerTeam("Aleksandr Samedov", "Russia");
		
		Stats::addPlayerUnique("Aleksandr Ryazantsev", 0);
		Stats::addPlayerPerTeam("Aleksandr Ryazantsev", "Russia");
		
		Stats::addPlayerUnique("Oleg Shatov", 0);
		Stats::addPlayerPerTeam("Oleg Shatov", "Russia");
		
		Stats::addPlayerUnique("Aleksei Ionov", 0);
		Stats::addPlayerPerTeam("Aleksei Ionov", "Russia");
		
		Stats::addPlayerUnique("Aleksandr Kerzhakov", 0);
		Stats::addPlayerPerTeam("Aleksandr Kerzhakov", "Russia");
		
		Stats::addPlayerUnique("Aleksandr Kokorin", 0);
		Stats::addPlayerPerTeam("Aleksandr Kokorin", "Russia");
		
		Stats::addPlayerUnique("Fyodor Smolov", 0);
		Stats::addPlayerPerTeam("Fyodor Smolov", "Russia");

		Stats::addPlayerPerMatch("Vincent Kompany", 1, 0, 90);
		Stats::addGoal(1, 22, "Vincent Kompany", "Belgium", 0);
		
		Stats::addPlayerPerMatch("Thibaut Courtois", 1, 0, 90);
		Stats::addPlayerPerMatch("Koen Casteels", 1, 0, 90);
		Stats::addPlayerPerMatch("Toby Alderweireld", 1, 0, 90);
		Stats::addPlayerPerMatch("Daniel Van Buyten", 1, 0, 90);
		Stats::addPlayerPerMatch("Simon Mignolet", 1, 0, 90);
		Stats::addPlayerPerMatch("Jan Vertonghen", 1, 0, 90);
		Stats::addPlayerPerMatch("Sébastien Pocognoli", 1, 0, 90);
		Stats::addPlayerPerMatch("Anthony Vanden Borre", 1, 0, 90);
		Stats::addPlayerPerMatch("Nacer Chadli", 1, 0, 90);
		Stats::addGoal(1, 57, "Nacer Chadli", "Belgium", 0);
		
		Stats::addPlayerPerMatch("Yuri Zhirkov", 1, 0, 90);
		Stats::addPlayerPerMatch("Roman Shirokov", 1, 0, 90);
		Stats::addPlayerPerMatch("Alan Dzagoev", 1, 0, 90);
		Stats::addPlayerPerMatch("Denis Glushakov", 1, 0, 90);
		Stats::addPlayerPerMatch("Viktor Fayzulin", 1, 0, 90);
		Stats::addPlayerPerMatch("Aleksandr Samedov", 1, 0, 90);
		Stats::addPlayerPerMatch("Aleksandr Ryazantsev", 1, 0, 90);
		Stats::addPlayerPerMatch("Oleg Shatov", 1, 0, 90);
		Stats::addPlayerPerMatch("Aleksei Ionov", 1, 0, 90);
		Stats::addPlayerPerMatch("Igor Denisov", 1, 0, 90);
		
		Stats::addGoal(1, 70, "Yuri Zhirkov", "Russia", 0);
		
		Stats::addCountry("Germany", "Europe", "ger");
		Stats::addCoach("Joachim Löw");
		Stats::addTeam("Germany", "Germany", "Joachim Löw", 1000);
		Stats::addTeamPerCompetition("Germany", "World Cup");
		Stats::addMatch("Germany", "Russia", "World Cup", "2014-01-20");

		
		Stats::addPlayerUnique("René Adler", 0);
		Stats::addPlayerPerTeam("René Adler", "Germany");
		
		Stats::addPlayerUnique("Ron-Robert Zieler", 0);
		Stats::addPlayerPerTeam("Ron-Robert Zieler", "Germany");
		
		Stats::addPlayerUnique("Marc-André ter Stegen", 0);
		Stats::addPlayerPerTeam("Marc-André ter Stegen", "Germany");
		
		Stats::addPlayerUnique("Mats Hummels", 0);
		Stats::addPlayerPerTeam("Mats Hummels", "Germany");
		
		Stats::addPlayerUnique("Heiko Westermann", 0);
		Stats::addPlayerPerTeam("Heiko Westermann", "Germany");
		
		Stats::addPlayerUnique("Benedikt Höwedes", 0);
		Stats::addPlayerPerTeam("Benedikt Höwedes", "Germany");
		
		Stats::addPlayerUnique("Dennis Aogo", 0);
		Stats::addPlayerPerTeam("Dennis Aogo", "Germany");
		
		Stats::addPlayerUnique("Philipp Wollscheid", 0);
		Stats::addPlayerPerTeam("Philipp Wollscheid", "Germany");
		
		Stats::addPlayerUnique("Andreas Beck", 0);
		Stats::addPlayerPerTeam("Andreas Beck", "Germany");
		
		Stats::addPlayerUnique("Lars Bender", 0);
		Stats::addPlayerPerTeam("Lars Bender", "Germany");
		
		Stats::addPlayerUnique("Thomas Müller", 0);
		Stats::addPlayerPerTeam("Thomas Müller", "Germany");
		
		Stats::addPlayerUnique("Sami Khedira", 0);
		Stats::addPlayerPerTeam("Sami Khedira", "Germany");
		
		Stats::addPlayerUnique("Marco Reus", 0);
		Stats::addPlayerPerTeam("Marco Reus", "Germany");
		
		Stats::addPlayerUnique("Julian Draxler", 0);
		Stats::addPlayerPerTeam("Julian Draxler", "Germany");
		
		Stats::addPlayerUnique("Sven Bender", 0);
		Stats::addPlayerPerTeam("Sven Bender", "Germany");
		
		Stats::addPlayerUnique("Ilkay Gundogan", 0);
		Stats::addPlayerPerTeam("Ilkay Gundogan", "Germany");
		
		Stats::addPlayerUnique("Aaron Hunt", 0);
		Stats::addPlayerPerTeam("Aaron Hunt", "Germany");
		
		Stats::addPlayerUnique("Stefan Reinartz", 0);
		Stats::addPlayerPerTeam("Stefan Reinartz", "Germany");
		
		Stats::addPlayerUnique("Nicolai Müller", 0);
		Stats::addPlayerPerTeam("Nicolai Müller", "Germany");
		
		Stats::addPlayerUnique("Roman Neustädter", 0);
		Stats::addPlayerPerTeam("Roman Neustädter", "Germany");
		
		Stats::addPlayerUnique("Patrick Herrmann", 0);
		Stats::addPlayerPerTeam("Patrick Herrmann", "Germany");
		
		Stats::addPlayerUnique("Pierre-Michel Lasogga", 0);
		Stats::addPlayerPerTeam("Pierre-Michel Lasogga", "Germany");
		
		Stats::addPlayerUnique("Max Kruse", 0);
		Stats::addPlayerPerTeam("Max Kruse", "Germany");
		
		Stats::addPlayerUnique("Mario Gómez", 0);
		Stats::addPlayerPerTeam("Mario Gómez", "Germany");
		
		Stats::addPlayerPerMatch("Mario Gómez", 2, 0, 90);
		Stats::addPlayerPerMatch("Max Kruse", 2, 0, 90);
		Stats::addPlayerPerMatch("Pierre-Michel Lasogga", 2, 0, 90);
		Stats::addPlayerPerMatch("Patrick Herrmann", 2, 0, 90);
		Stats::addPlayerPerMatch("Roman Neustädter", 2, 0, 90);
		Stats::addPlayerPerMatch("Nicolai Müller", 2, 0, 90);
		Stats::addPlayerPerMatch("Stefan Reinartz", 2, 0, 90);
		Stats::addPlayerPerMatch("Aaron Hunt", 2, 0, 90);
		Stats::addPlayerPerMatch("Ilkay Gundogan", 2, 0, 90);
		Stats::addGoal(2, 57, "Ilkay Gundogan", "Germany", 0);
		
		Stats::addPlayerPerMatch("Yuri Zhirkov", 2, 0, 90);
		Stats::addPlayerPerMatch("Roman Shirokov", 2, 0, 90);
		Stats::addPlayerPerMatch("Alan Dzagoev", 2, 0, 90);
		Stats::addPlayerPerMatch("Denis Glushakov", 2, 0, 90);
		Stats::addPlayerPerMatch("Viktor Fayzulin", 2, 0, 90);
		Stats::addPlayerPerMatch("Aleksandr Samedov", 2, 0, 90);
		Stats::addPlayerPerMatch("Aleksandr Ryazantsev", 2, 0, 90);
		Stats::addPlayerPerMatch("Oleg Shatov", 2, 0, 90);
		Stats::addPlayerPerMatch("Aleksei Ionov", 2, 0, 90);
		Stats::addPlayerPerMatch("Igor Denisov", 2, 0, 90);
		
		Stats::addMatch("Germany", "Belgium", "World Cup", "2014-01-24");
		Stats::addPlayerPerMatch("Mario Gómez", 3, 0, 90);
		Stats::addPlayerPerMatch("Max Kruse", 3, 0, 90);
		Stats::addPlayerPerMatch("Pierre-Michel Lasogga", 3, 0, 90);
		Stats::addPlayerPerMatch("Patrick Herrmann", 3, 0, 90);
		Stats::addPlayerPerMatch("Roman Neustädter", 3, 0, 90);
		Stats::addPlayerPerMatch("Nicolai Müller", 3, 0, 90);
		Stats::addPlayerPerMatch("Stefan Reinartz", 3, 0, 90);
		Stats::addPlayerPerMatch("Aaron Hunt", 3, 0, 90);
		Stats::addPlayerPerMatch("Ilkay Gundogan", 3, 0, 90);
		Stats::addGoal(3, 57, "Ilkay Gundogan", "Germany", 0);
		
		Stats::addPlayerPerMatch("Thibaut Courtois", 3, 0, 90);
		Stats::addPlayerPerMatch("Koen Casteels", 3, 0, 90);
		Stats::addPlayerPerMatch("Toby Alderweireld", 3, 0, 90);
		Stats::addPlayerPerMatch("Daniel Van Buyten", 3, 0, 90);
		Stats::addPlayerPerMatch("Simon Mignolet", 3, 0, 90);
		Stats::addPlayerPerMatch("Jan Vertonghen", 3, 0, 90);
		Stats::addPlayerPerMatch("Sébastien Pocognoli", 3, 0, 90);
		Stats::addPlayerPerMatch("Anthony Vanden Borre", 3, 0, 90);
		Stats::addPlayerPerMatch("Nacer Chadli", 3, 0, 90);
		Stats::addGoal(3, 57, "Nacer Chadli", "Belgium", 0);
		Stats::addPlayerPerMatch("Vincent Kompany", 3, 0, 81);
		Stats::addCard("Vincent Kompany", 3, 2, 81);*/
		
		?>
