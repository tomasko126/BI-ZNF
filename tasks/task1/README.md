# BI-ZNF

## Cvičení 1

Varianta A projektu pro první cvičení předmětu BI-ZNF.

### Úkol

1. Naklonujte si projekt do adresáře vašeho lokálního webového serveru.
2. Jděte do složky projektu a nainstalujte ho pomocí přikazu ``composer install``.
3. Vyzkoušejte, že vidíte úvodní stránku pro příslušnou URL adresou (např. http://localhost/cviceni01).
4. Implmentujte chybějící matematické operace v modelu kalkulačky - */app/model/CalculatorManager.php*.
5. Ověřte vaši implementaci spuštěním jednotkových testů v projektu pomocí [Nette Tester](https://tester.nette.org/cs/)
```shell
vendor/bin/tester tests # Linux
# NEBO
vendor/bin/tester.bat tests # Windows
# NEBO
php vendor/nette/tester/src/tester tests # Přímo pomocí PHP
```

6. Vyzkoušejte postupně všechny matematické operace přímo v prohlížeči pomocí GET parametrů URL:
	* Sčítání - */add/\<number1\>/\<number2\>*
	* Odčítání - */sub/\<number1\>/\<number2\>*
	* Násobení - */mul/\<number1\>/\<number2\>*
	* Dělení - */div/\<number1\>/\<number2\>*
7. Pro ty co to nestihnou na cvičení
	* Modulo - */mod/\<number1\>/\<number2\>*
	* Mocnina - */pow/\<number1\>/\<number2\>*
	* Druhá odmocnina - */sqrt/\<number1\>*
	* Automatizované testy pro nově přidané operace
