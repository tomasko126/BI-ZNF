# BI-ZNF

## Cvičení 5

Projekt pro páté cvičení předmětu BI-ZNF.


​1. Použijte Vaši předchozí úlohu nebo si naklonujte a nainstalujte předchozí (příkaz „composer install“) projekt 04a do vašeho lokálního adresáře.

​2. Vytvořte si databázovou strukturu (MySQL) podle přítomného *SQL scriptu* a nastavte přístup k dané databázi v konfiguračním souboru („app/config/config.local.neon“)

​3. Vytvořte jednotkový test pro otestování správné validace rodného čísla

* Testujte jak správné vstupy, tak i nesprávné včetně 29. února

​4. Vytvořte jednotkový testy modelu pro vkládání, editaci a mazání uživatelů.
* Je potřeba pokrýt celou funkcionalitu modelu
* Testy udělejte jak pro správné, tak nesprávné vstupy
* Otestujte také mazání v případě existence nákupu
* Testy musí uvést DB do původního stavu (i v případě neúspěchu testů)

​5. Vytvořte komponentu pro statistiku

* chování je stejné jako v presenteru Statistik - nahrazuje ji.
* má jeden parametr a to id (id uzivatele), pokud je id definováno a je validní, zobrazí se jen statistika nákupů, které uživatel udělal, pokud je NULL, ukáže statistiky všech nákupů
* vytvořte u šablonu detail (pro UserPresenter), která zobrazí statistiku nákupů, které zaměstnanec provedl

​6. Úprava daně
* doplňte do OrderModel metodu pro výpočet daně (dle EET půjde o velmi složitý výpočet ;->), metodu si zvolte sami.
* upravte v šabloně default výpočet daně, aby byl využit výpočet z modelu.
* do formuláře vložení a editace objednavky přidejte výpočet daně tak, že v případě změny ceny se automaticky aktualizuje daň (bez odeslání formuláře) - nápověda handle a ajax

​7. Ajaxizujte formuláře „UserFormFactory“ tj proveďte validaci formuláře prostřednictvím AJAXového volání a případné změny ve formuláři proveďte pomocí aktualizace snipetů