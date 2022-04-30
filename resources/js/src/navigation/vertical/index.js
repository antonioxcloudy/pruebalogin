export default [
    {
      title: 'Home',
      route: 'home',
      icon: 'HomeIcon',
      action: 'read',
      resource: 'Auth',
    },
    {
      title: 'Second Page',
      route: 'second-page',
      icon: 'FileIcon',
    },
    {
      action: 'read',
      resource: 'Auth',
      title: 'Gestion de Usuarios',
      icon: 'HomeIcon',
      tag: '2',
      tagVariant: 'light-warning',
      children: [
        {
            action: 'read',
            resource: 'Auth',
          title: 'Roles',
          route: 'roles-listar',
        },
        {
            action: 'read',
            resource: 'Auth',
          title: 'Usuarios',
          route: 'usuarios-listar',
        },
       
      ],
      
    },
  ]
  
  
  
  
  
  