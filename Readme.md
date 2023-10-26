<h1 align="center">Rozetka.ua Gateway (Pet Project)</h1>

> This gateway is an intermediary between Rozetka.ua and the client's CRM systems. The main task is to synchronize the product catalog, create a YML file of the product catalog, receive orders and send them to the queue, update the order on request from the CRM system

🚀 Usage:
-------------

Run services from dev/docker/docker-compose.yml file

- memcached
- cron
- downloader_primary
- downloader_secondary
- server
- db

Memcached
-------------
Memcached is a general-purpose distributed memory caching system

Cron
-------------
Based on Symfony 6.3 Scheduler Component. Each cron task represents a message and a handler that intercepts the message. See [TaskProvider.php](src/Cron/TaskProvider.php)

Primary and secondary downloader
-------------
Concurrent services that load task information from a queue and place the result in another recipient's queue.

Server
-------------
Main App container

DB
-------------
MySQL container
