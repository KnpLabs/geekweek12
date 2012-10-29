Feature: Browse cheeses
    In order to choose cheeses to buy
    As a buyer
    I should be able to browse cheeses

    Background:
        Given the following products:
            | Name        | Region    | Type of milk | rating |
            | Camembert   | Normandie | Vache        | 5/5    |
            | Gruyère     | Suisse    | Vache        | 2/5    |
            | Maroilles   | Nord      | Vache        | 2/5    |
            | Munster     | Nord      | Vache        | 3/5    |
            | Ossau-Iraty | Pyrenées  | Brebis       | 5/5    |
            | Roquefort   | Aveyron   | Brebis       | 1/5    |

    Scenario: Display the 3 most rated cheeses on the homepage
        Given I am on the homepage
         Then I should see cheeses Camembert, Ossau-Iraty and Munster

    Scenario: Display cheeses of a specific Region
        Given I am on the homepage
         When I follow the "Nord" link from the menu
         Then I should see cheeses Maroilles and Munster

    Scenario: Display cheeses of a specific Region
        Given I am on the homepage
         When I follow the "Brebis" link from the menu
         Then I should see cheeses Ossau-Iraty and Roquefort
