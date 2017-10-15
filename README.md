# everydb
A virion for convenient indexed data saving.

## What is this?
Everydb is a [virion](https://poggit.pmmp.io/virion) for PocketMine plugins to save a lot of indexed data, e.g. data for each player.

Everydb provides 4 main types of data providers, namely ["single"](#single-data-provider), ["multi"](#multi-data-provider), ["sqlite"](sqlite-data-provider) and ["mysql"](mysql-data-provider). Users (the server owners, not the plugin developers) can choose which data provider to use.

Plugins using everydb only need to have a "schema" file. It tells everydb what the plugin wants to save. Then, let the user choose what data provider to use in the config.yml, and everydb will handle everything on the database.

However, everydb does not analyze the data for you. If you need to track things like max/min values, mean values, standard deviation, etc., you need to write the logic yourself.

## Types of data provider
### Single data provider
All data are saved in the same file using a data serialization format. Available formats include:
* YAML
* JSON (you can choose "pretty" JSON or "minimized" JSON)
* SL (PHP serialization language, something that looks like `a:1:{s:5:"steve";a:2:{s:5:"kills";i:100;s:6:"deaths";i:50;}}`
* NBT (same format as the files in the players/ directory, you can download an NBT reader to edit it)

**Advantages**:
* This is usually convenient for editing (especially if it is YAML, or you may want to use an NBT browser).
* Only one file is created. You can easily load all data at once (esp. if you need to analyze data, e.g. find the average/max/min).
  * However, analyzing

**Disadvantages**:
* The file size increases as your server generates more data. Loading/saving data will easily become laggy.
  * This problem is very serious. Since all data must be loaded together, there is always a big chunk of RAM wasted for storing the saved data temporarily.

### Multi data provider
The data for each index (e.g. each player) is saved in an independent file. Each file uses a data serialization format, with the same choices as the ones for [single data provider](#single-data-provider).

The data can be saved with nested prefix directories, e.g. `players/steve.yml` or `players/s/steve.yml`.

**Advantages**:
* Loading/saving data is very fast if you only need to load/save one index (e.g. one player) each time.
* This is usually convenient for editing (especially if it is YAML, or you may want to use an NBT browser).

**Disadvantages**:
* A lot of files are created. It will be very slow to load all data if you need to analyze them.
* If you need to track the maximum value, minimum value, etc., you need to pre-calculate it. But everydb won't help you with that.

### SQLite data provider
All data are saved in the same file using the SQLite3 format. This is different from [single data provider](#single-data-provider), because the data are indexed, and there is no need to read/write **all** data at once.

**Advantages**:
* Only one file is created. The data can be analyzed very quickly (even faster than single data provider).
* There is no significant read/write lag.
  * For single data provider, the lag is very significant when the data are saved, and a large amount of data are transferred while reading/writing, so it is laggy even with the help of AsyncTask.
  * For SQLite data provider, basically, only the parts of the file with relevant data are read/written, so all other irrelevant data (except the index) are skipped and do not affect the performance.

**Disadvantages**:
* Editing the file requires special tools, and some knowledge on SQL is necessary. Not every user can learn how to edit it.

### MySQL data provider
The data are saved on a remote server (can still be on the same machine). Data are transferred across the Internet.

**Advantages**:
* The data can be shared across multiple servers.
* A dedicated process is used to manage the database. Since everydb uses asynchronous connections, the server performance is not affected by data saving at all.

**Disadvantages**:
* The user needs to install and setup a MySQL server. This may be confusing for some users.
