# Apache Handling connections

Process-driven architecture, single thread for each connection request 

Many requests can lead to heavy resource consumption

Multi-processing modules (MPMs) determine HTTP requests.

**Mpm_prefork**

Each child process can only handle one request at a time

Does not scale effectively

**Mpm_worker**

Worker can create multiple threads for a connection

Threads are less resource intense then processes

**Mpm_event**

Lowest resource requirements

Couple threads managing live connections
