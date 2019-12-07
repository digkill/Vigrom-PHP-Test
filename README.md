# Тестовое задание Vigrom
#### Запуск docker-compose up -d --build

#### Роуты
- /wallets/create
- /wallets/balance
- /wallets/change-balance

```sql
SELECT ROUND(SUM(ag),2) FROM
((select SUM(w.balance) as ag
from wallets as w
left join `loggers` l on l.wallet_id = w.id and l.cause = 'refund'
where l.created_at >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY) and w.currency = 'USD')
UNION ALL
(select SUM(w.balance) / 65 from wallets as w
left join `loggers` l on l.wallet_id = w.id and l.cause = 'refund'
where l.created_at >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY) and w.currency = 'RUB')) A
```
