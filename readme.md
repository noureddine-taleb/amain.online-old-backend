coding convention:
    - DRY code
    - separate all configuration in environement file
    - define exception handler in specific location
    - route names should be compatible/start with tables(resource) and contains only selef descriptive names. and the method should describe the action. the uri parts should be hirarchical. and "-" separated words
    - always throw exception if there is problem (4xx) instead of return response with that code to the client. this helps in error/bug reporting
    - controller/resource for each resource
    - each resource should have it's own routes/controller/model
    - test everythink php-unit