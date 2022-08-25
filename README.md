1. Creating a new account
```
[POST] /api/client
```
Example JSON Input Data:
```bash
{
    "name": "John Smith",
    "accountNumber": "25464565634534534534534578",
    "email": "john.smith@example.com",
    "phoneNumber": "846375357"
}
```

2. Depositing money
```
[POST] /api/transcation
```
Example JSON Input Data:
```bash
{
    "moneyDeposit": "7500.45",
    "client": 1
}
```

3. Withdrawing money
```
[POST] /api/money/transcation
```
Example JSON Input Data:
```bash
{
    "moneyWithdrawal": "5000.37",
    "client": 1
}
```

4. Checking current money balance
```
[GET] /api/money/{client_id}/balance
```

5. Checking transaction history
```
[GET] /api/money/{client_id}
```

6. Checking transaction history (CLI)
```
php bin/console transaction-history <client_id>
```

Installation
------------

```bash
$ composer install
$ php bin/console doctrine:migrations:diff
$ php bin/console doctrine:migrations:migrate
$ php bin/console symfony serve -d --no-tls
```
