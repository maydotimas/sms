/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const studentRoutes = {
  path: '/student',
  component: Layout,
  redirect: '/student/list',
  name: 'Student',
  alwaysShow: true,
  meta: {
    title: 'student',
    icon: 'people',
    permissions: ['view menu student'],
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
      path: 'edit/:id(\\d+)',
      component: () => import('@/views/students/NewStudent'),
      name: 'EditStudent',
      meta: { title: 'editStudent', noCache: true, permissions: ['manage parent'] },
      hidden: true,
    },
    {
      path: 'list',
      component: () => import('@/views/students/List'),
      name: 'MasterList',
      meta: { title: 'students', icon: 'user', permissions: ['manage student'] },
    },
    {
      path: 'reservation',
      component: () => import('@/views/reservation/List'),
      name: 'studentReservation',
      meta: { title: 'studentReservation', icon: 'form', permissions: ['manage reservation'] },
    },
    {
      path: 'enrollment',
      component: () => import('@/views/enrollment/List'),
      name: 'StudentEnrollment',
      meta: { title: 'studentEnrollment', icon: 'skill', permissions: ['manage student'] },
    },
  ],
};

export default studentRoutes;
