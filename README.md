### About
web service factoring company can use to adding companies, adding invoices and marking an 
invoice as paid.

Invoice factoring is a financial transaction in which a business sells its outstanding invoices to a factoring company at a discount. Businesses that offer goods or services to other businesses use factoring to access immediate cash flow.

### Solution Approach 
the approach use is Single-installment transaction which the company sells its invoices with discount to the factoring company.
* First: the admin add companies with type creditor or debtor.
* Second: the admin add invoice related to those 2 companies with the total invoce amount ( the webserver first check if the debtor reach the creditor debit limit).
* third : the admin can mark the inoice as paid invoice .


Note : A simple auth system is implemented which required the admin should logged in and authorized to access the web services)

### Technologies
PHP8

laravel Framework 8

### Prerequisites
PHP 8

Apache

Composer

### Installation
1.unzip the file

2.run `composer install`

3.change `.env.example file to .env `

4.`set the db name in DB_DATABASE , db username in DB_USERNAME and db password in DB_PASSWORD `
 
5.run `php artisan migrate`

6.run `php artisan db:seed`

 7.run `php artisan serve`

### Test
Run `php artisan test`

### Apis
https://documenter.getpostman.com/view/2448445/TzscpSWL
