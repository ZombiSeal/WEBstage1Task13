# WEBstage1Task13
## Задание1. 
1.Спарсить файл «pricelist.xls»  в базу данных (в отдельную таблицу со всеми полями из прайслиста).
2.Вывести на страницу таблицу со всеми товарами (все поля + столбец «примечание»).
Товары должны быть разбиты на разедлы (где они есть, где нет разедла, вывести товары без раздела) 
3.Вывести под таблицей общее количество товаров на Складе1 и на Складе2.
4.Вывести под таблицей среднюю стоимость розничной цены товара.
5.Вывести под таблицей среднюю стоимость оптовой цены товара.
6.Выделить в таблице красным цветом самый дорогой товар (по рознице).
7.Выделить в таблице зеленым цветом самый дешевый товар (по опту).
8.Если товара на складе осталось менее 20шт, то в столбце таблицы «примечание» вывести фразу «Осталось мало!! Срочно докупите!!!».

## Задание 3.
Будем работать с таблицей, которую Вы строили на первом модуле курса.
Вам потребуется разработать простой фильтр с помощью технологии AJAX (выборка данных без перезагрузки страницы).
Реализовать логическую выборку данных (фильтрацию) из полученной ранее таблицы прайслиста по следующей структуре: https://wnd1e1.ax	share.com/ 
Важно! Должна быть реализована валидация полей на наличие/корректность вводимых значений и предусмотрена базовая защита от SQL инъекций через эти поля.
