coding convention:
    - DRY code
    - separate all configuration in environement file
    - define exception handler in specific location
    - route names should be compatible/start with tables(resource) and contains only selef  
        descriptive names. and the method should describe the action. the uri parts should be    
        hirarchical. and "-" separated words
    - always throw exception if there is problem (4xx) instead of return response with that 
        code to the client. this helps in error/bug reporting
    - controller/resource for each resource
    - each resource should have it's own routes/controller/model
    - test everythink php-unit
    - in case of client side error return 4xx and set error key
    - in case of 2xx set message key
    - no try catch in req handlers
    - return 404 only if the client want a very specific resource(single) otherwise(collection) return 2xx with empty data
    - create/update:
        consistency in : validation ---> eloquent ----> database fields
    - read/delete:
        satisfy user needs if resource exists otherwise return not found 404
    - api server should protect its resource and try to avoid 500 status
    
DEVOPS Methodology:
    -docker
    -ci/cd pipelines
    -git:
        -create 2 branches (master-develop)
            -master will contain current release
            -develop used for developpement and testing and feature creation
        -develop is the only branch opened for commits
        -use tags to versioning (linux kernel convention) <major>,<minor>,<patch>
        -use commits convention (that include emojis)