/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const syRoutes = {
  path: '/school-year',
  component: Layout,
  redirect: '/student/list',
  name: 'School Year',
  alwaysShow: true,
  meta: {
    title: 'student',
    icon: 'education',
    permissions: ['view menu administrator'],
  },
  children: [
    /** User managements */
    {
      path: 'new/',
      component: () => import('@/views/students/NewStudent'),
      name: 'NewStudent',
      meta: { title: 'newStudent', noCache: true, permissions: ['manage student'] },
      hidden: true,
    },
    {
      path: 'list',
      component: () => import('@/views/students/List'),
      name: 'MasterList',
      meta: { title: 'students', icon: 'user', permissions: ['manage student'] },
    },
    {
      path: 'list',
      component: () => import('@/views/students/List'),
      name: 'StudentReservation',
      meta: { title: 'studentReservation', icon: 'form', permissions: ['manage student'] },
    },
    {
      path: 'list',
      component: () => import('@/views/students/List'),
      name: 'StudentEnrollment',
      meta: { title: 'studentEnrollment', icon: 'skill', permissions: ['manage student'] },
    },
  ],
};

export default syRoutes;
