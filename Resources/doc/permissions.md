# How to use permissions

## How this work

Everytime transformer makes new object it checks available permissions 
for it and add it to "_permissions" property, and you can access it in angular
like **object._permissions** and use like 

    {{ (deal._permissions.view ? '' : 'hidden') }}

To make your permissions for some class of object you should 
make special handler to namespace Perfico\ApiBundle\Permissions\Types 
that implements HandlerInterface for this **class** of objects.

For example, check **Perfico\ApiBundle\Permissions\Types\DealHandler**

1. Method **getObjectClass** should return classname of acceptable objects.
1. Method **permissions** should return array that will be accessible in frontend as _permissions property of object.

For example:

    $permissions = [];
    $permissions['view'] = $this->sc->isGranted('MY_VIEW_ALL')
        || ($this->sc->isGranted('MY_VIEW_OWN')
        && $object->getUser() == $this->user)
    ;
    return $permissions;


## In controller

### checkAnyRole
To limit ROLES you can use checkAnyRole (user should have one of these roles):

    if (!$this->get('perfico_crm.permission_manager')->checkAnyRole(['ROLE_DEAL_VIEW_ALL', 'ROLE_DEAL_VIEW_OWN'])) {
        return new JsonResponse([], 403);
    }
    
### checkObjectRole    
To limit acccess to some object, you can use: 
    
    if (!$this->get('perfico_crm.permission_manager')->checkObjectRole($client, 'VIEW')) {
        return new JsonResponse([], 403);
    }    
    
For this you should define your rules in **checkAction** of handler, for example:

    if (!$object instanceof Deal) {
        return false;
    }
    if ($this->sc->isGranted(self::ROLE_PREFIX . $action)) {
        return true;
    }
    if ($this->sc->isGranted(self::ROLE_PREFIX . $action . '_OWN') && $object->getUser() == $this->user) {
        return true;
    }
    return false;
    


