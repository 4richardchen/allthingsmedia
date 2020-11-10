# Answer

```sh
# start services
docker-compose up

# get to mysql command line
docker exec -it atmcodetest_db_1 mysql -uroot -patm users_db

# part A answer
SELECT DATE(users.created) `DATE`,
	SUM(CASE WHEN users_details.job_role='' THEN 1 ELSE 0 END) 'CORP',
	SUM(CASE WHEN users_details.job_role='DLR-PRIN' THEN 1 ELSE 0 END) 'DLR-PRIN',
	SUM(CASE WHEN users_details.job_role='GEN-MGR' THEN 1 ELSE 0 END) 'GEN-MGR',
	SUM(CASE WHEN users_details.job_role='SL-MGR' THEN 1 ELSE 0 END) 'SL-MGR',
	SUM(CASE WHEN users_details.job_role='SV-SM' THEN 1 ELSE 0 END) 'SV-SM',
	SUM(CASE WHEN users_details.job_role='PT-PM' THEN 1 ELSE 0 END) 'PT-PM'
FROM users_details
LEFT JOIN users
ON users_details.user_id = users.id
WHERE DATE(users.created) BETWEEN '2020-04-21' AND '2020-10-31'
GROUP BY 1
ORDER BY 1 DESC;

# part B answer
open http://localhost/

# run when done
docker-compose down
```

# Discussion

Values I practiced:
* use minimum time so no
  * [PSR](http://php-fig.org/psr/psr-12/) checks
  * code formatter
  * unit tests
    * add [phpunit](https://hub.docker.com/r/phpunit/phpunit/) to docker-compose
* stick to directions which suggest no design
* keep everything in docker so anyone sees identical execution locally
* minimal documentation, comments
