# Question

## Purpose and Details

The purpose of this exercise is to evaluate the use of PHP/MYSQL and just MYSQL to create a pivot table from data that is organized and logically associated.

Contained in the SQL directory you will find a test database that contains two tables.  Each table contains around 14,000 records. 

## Part A 

Contained within the users_details table you will find a column "job_role".  A report must be generated to display the number of registrations by DATE for 6 specific Job Roles, though there are 50+.  

We are concerned about the following roles:

CORP **
DLR-PRIN
GEN-MGR
SL-MGR
SV-SM
PT-PM

**CORP is not listed in the Database under job_role.  This role is defined by an EMPTY value in the job_role column.


Complete the following assessment:

Using MYSQL only, develop a query, view, or procedure that displays the number of users that have REGISTERED by DATE from 2020-04-21 to 2020-10-31.  Organize the data as follows:

DATE | CORP | DLR-PRIN | GEN-MGR | SL-MGR | SV-SM | PT-PM

The desired output format is:

| date | CORP | DRL-PRIN | GEN-MGR | SL-MGR | SV-SM | PT-PM |
|---|---|---|---|---|---|---|
| 2020-09-18 | 4 | 1 | 2 | 1 | 3 | 1 |
| 2020-09-19 | 0 | 1 | 1 | 1 | 0 | 0 |
| 2020-09-20 | 4 | 1 | 2 | 1 | 3 | 1 |
| 2020-09-21 | 4 | 1 | 2 | 1 | 3 | 1 |

Parameters:
- No changes to the data structure can be made
- Only SQL can be used.

Deliverable: 
- All SQL files to prove functionality
- Any instructions required to execute code. 

## Part B

A second request has come in, and we now must generate a report to display the number of registrations by DATE for ALL job roles.  Note there are 50+

**CORP is not listed in the Database under job_role.  This role is defined by an EMPTY value in the job_role column.


Complete the following assessment: 

Using PHP and MYSQL, develop a page that displays an HTML table (no design required) that organizes the data and dynamically adjusts the table columns any of the job roles present. Add 2  additional column, 
1 Column for the total count of registered users for the given date and 1 column for the count of users who have last accessed on that date. 

Date Range should be from 2020-04-21 to 2020-10-31

The output should look something like this: 

| DATE | COUNT | LAST ACCESS COUNT | CORP | DLR-PRIN | GEN-MGR | SL-MGR | SV-SM | PT-PM |...|...|...|...|...|... |

Parameters: 
- Do not use Procedures or Views to execute this. The database user when tested will not have CALL permissions. 
- No use of PHP Frameworks. 
- At the top of the page, display "Start time:" on screen, use the PHP time() function.  At the end of the page, display "END TIME:" on screen, use the PHP time() function. This will assess execution time. 
- No changes to the data structure can be made

Deliverable:
- All PHP code required to display table
- Any and all instructions on making the code work.

Note:
- When being tested, a random user with a new and random job role will be added to prove that the table dynamically expands the number of columns and appropriate counts.   

# My Answer

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
