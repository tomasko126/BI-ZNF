# BI-ZNF

    ## Cvičení 2
    
    Varianta A projektu pro druhé cvičení předmětu BI-ZNF.
    
    ### Úkol
    
    1. Naklonujte si a nainstalujte (příkaz ``composer install``) projekt do vašeho lokálního adresáře.
    2. Vytvořte si databázovou strukturu (MySQL) podle přítomného **SQL scriptu** a nastavte přístup k dané databázi v konfiguračním souboru (``app/config/config.local.neon``)
    3. Doplňte funkcionalitu do třídy ``UserModel`` 
        * Podle uvedených **TODO** tak, aby odpovídala dokumentaci
        * Navíc ošetřete vstupní data modelu (hlavně u použití metod *insert()* a *update()*)
        např.: validní znaky uživatelského jména, délku a obsah znaků hesla atd.  
        * Dále ošetřete operace (hlavně u metod *get()*, *delete()*, *update()*) vůči neexistujícím datům (vyhoďte výjimku ``NoDataException``)
    4. Doplňte funkcionalitu do třídy ``UserPresenter``
        * Podle uvedených **TODO** tak, aby odpovídala dokumentaci
        * Především naplnění formulářů daty v rámci daných metod ``action*()``
        * Dále metodu ``renderDefault()`` o předání příslušných dat do šablony (zachovejte jména atributů z databáze) 
    5. Ověřte si funkčnost sekce webu pro správu uživatelů
    6. Doplňte funkcionalitu do třídy ``OrderModel``
        * Podle uvedených **TODO** tak, aby odpovídala dokumentaci
        * Navíc ošetřete vstupní data modelu (hlavně u použití metod *insert()* a *update()*)
        * Dále ošetřete operace (hlavně u metod *get()*, *delete()*, *update()*) vůči neexistujícím datům (vyhoďte výjimku ``NoDataException``)
    7. Doplňte funkcionalitu do třídy ``OrderPresenter``
        * Podle uvedených **TODO** tak, aby odpovídala dokumentaci
        * Především naplnění formulářů daty v rámci daných metod ``action*()``
        * Dále metodu ``renderDefault()`` o předání příslušných dat do šablony (zachovejte jména atributů z databáze)
        * V Latte šabloně je pak použita relace na tabulku pomocí **cizího klíče**, který je ale potřeba **doplnit v databázi**
    8. Ověřte si funkčnost sekce webu pro nákupy
    9. Doplňte metodu ``listStatistic()`` třídě ``StatisticModel``
        * Pro získání statistických údajů nákupů podle **TODO** tak, aby odpovídala dokumentaci
        např.: minimální cenu, maximální cenu, součet ceny všech nákupů atd.
