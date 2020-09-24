/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const studentRoutes = {
  path: '/parent',
  component: Layout,
  redirect: '/parent/list',
  name: 'Parent',
  alwaysShow: true,
  meta: {
    title: 'parents',
    icon: 'people',
    permissions: ['view menu administrator'],
  },
  children: [
    /** User managements */
    /* {
      path: 'edit/:id(\\d+)',
      component: () => import('@/views/parents/StudentProfile'),
      name: 'StudentProfile',
      meta: { title: 'studentProfile', noCache: true, permissions: ['manage parent'] },
      hidden: true,
    }, */
    {
      path: 'new/',
      component: () => import('@/views/parents/NewParent'),
      name: 'NewParent',
      meta: { title: 'newParent', noCache: true, permissions: ['manage parent'] },
      hidden: true,
    },
    {
      path: 'list',
      component: () => import('@/views/parents/List'),
      name: 'ParentList',
      meta: { title: 'parents', icon: 'people', permissions: ['manage parent'] },
    },
  ],
};

export default studentRoutes;
