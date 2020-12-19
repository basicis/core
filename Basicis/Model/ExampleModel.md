# Basicis\Model\ExampleModel  

ExampleModel class

 @ORM\MappedSuperclass  

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
|delete|Function delete
Remove data of this entity of database|
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
|getUpdated|Get updated.|
|save|Function save
Save data of this entity to database, use for create or update entities|
|setCreated|Function setCreated.|
|setUpdated|Function setUpdated
Return entity updated timestamp|


