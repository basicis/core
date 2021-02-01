# Basicis\Model\ExampleModel  

ExampleModel class

## Implements:
Stringable, Basicis\Model\ModelInterface

## Extend:

Basicis\Model\Model

## Methods

| Name | Description |
|------|-------------|

## Inherited methods

| Name | Description |
|------|-------------|
|__construct|Function function|
|__toArray|Function __toArray
Get Entity Data as Array, without the propreties defined in the array property $protecteds|
|__toString|Function __toString
Get Entity Data as Json, without the propreties defined in the array property $protecteds|
|all|Function all
Find all entities|
|allToArray|Function all
Find all entities, and return a array or null|
|delete|Function delete
Remove data of this entity of database|
|exists|Function exists
Check if a entity by any column match|
|find|Function find
Find a entity by id|
|findBy|Function findBy
Find all entities by any column match|
|findOneBy|Function findOneBy
Find a entity by any column match|
|getCreated|Function getCreated
Return entity created timestamp|
|getId|Function getId
Return entity ID (unique on system identification)|
|getManager|Function getManager
Get a instance of Doctrine ORM EntityManager an return this, or null|
|getPropertyAnnotation|Function getPropertyAnnotation
Get a array with property annotations data by prop and tag names, default tag `Column`|
|getProtecteds|Function getProtecteds
Get protecteds properties|
|getTableName|Function getTableName
Get entity table name|
|getUpdated|Function getUpdated
Return entity updated timestamp|
|paginate|Function paginate
Paginate entity search with start offset (0) and total, this is ten (10) by default|
|query|Function query
Execute a sql query string|
|removeProtecteds|Function removeProtecteds
Get Entity Data as Array, without the propreties defined in the array property $protecteds|
|save|Function save
Save data of this entity to database, use for create or update entities|
|setCreated|Function setCreated
Set entity creation timestamp|
|setUpdated|Function setUpdated
Set entity updated timestamp|

