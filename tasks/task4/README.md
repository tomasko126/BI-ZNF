# BI-ZNF

## Cvičení 4

Varianta A projektu pro čtvrté cvičení předmětu BI-ZNF.


<note>git clone git@gitlab.fit.cvut.cz:BI-ZNF/cviceni04a.git </note>

<note important>Hodnocena bude také uživatelská srozumitelnost. Pozor na mazání.</note>

1. Použijte Vaši předchozí úlohu (doporučuji, protože cest k řešení 3. úlohy je mnoho) nebo si naklonujte a nainstalujte (příkaz "composer install") projekt 04a do vašeho lokálního adresáře.

2. (Není nutné pokud pokračujete) Vytvořte si databázovou strukturu (MySQL) podle přítomného **SQL scriptu** a nastavte přístup k dané databázi v konfiguračním souboru ("app/config/config.local.neon")

3. Upravte všechny formuláře tak, aby nepoužívali validaci na úrovni JS.

4. V továrně "UserFormFactory" upravte následující
  * přidejte validaci příjmení tak, aby připouštěla jen písmena (první velké, ostatní malá), minimální délku 5 a maximální 30 znaků. 
  * přidejte validaci jména tak, aby připouštěla jen písmena (první velké, ostatní malá), minimální délku 5 a maximální 30 znaků.
  * přidejte validaci telefonu tak, aby připouštěla 9 čísel nebo 13, ale první 4 musí být +420. Do DB se ukládá 9 číselná varianta
  * přidejte celočíselnou položku osobní číslo (upravte i model a DB)
  * v případě, že je vyplněno příjmení Chludil nebo Máca, se is_admin automaticky odešle jako true.
  * přidejte validaci osobního čísla tak, aby připouštěla 6 čísel a položka byla povinná pokud není zaškrtnuto je administrátor?
  
5. V továrně "OrderFormFactory" upravte následující
  * přidejte validaci množství tak, aby připouštěla jen kladná celá čísla s maximem 100.
  * přidejte validaci ceny tak, aby připouštěla jen kladná reálná čísla s minimem 1.

6. V továrně "PidFormFactory" upravte následující
  * přidejte validaci rodného čísla. 
  

7. Vytvořte novou továrnu GDPROrderFormFactory
  * Bude používána v presenteru OrderPresenter (bude mít vlastní Vytvoř (GDPR), edit (GDPR) a delete (GDPR) tlačítko)
  * V případě otevření jednotlivých formulářů se objeví hlášení "V tomto formuláři budou zpracovávána osobní data, máte příslušné povolení?" a tlačítka ANO-NE
  * NE - ukončí fomulář, ANO - uživateli se objeví jedna z pěti předdefinovaných otázek ala "Kdo bdí nad bezpečností všech dat?" a selector s možnostmi např. (Facebook, Google, EU, Schopní administrátoři) z niž jedna musí být správná. Výběr otázek a odpovědí je na Vás.
  * V případě správné odpovědí, se objeví původní adresář, ale všechna jména uživatel budou šifrovaná. Ostatní funkčnost bude odpovídat OrderFormFactory     

8. Změňte vzhled formuláře "User" pomocí úpravy wrappers (použijte tagy dl, dd a dt)  

9. Změňte vzhled formuláře "Order" pomocí manuálního vykreslováním.  
