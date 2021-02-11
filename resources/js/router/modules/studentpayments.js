/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const studentPaymentRoutes = {
  path: '/studentpayment',
  component: Layout,
  redirect: '/studentpayment/list',
  name: 'StudentPayments',
  alwaysShow: true,
  meta: {
    title: 'configuration',
    icon: 'excel',
    permissions: ['view menu studentpayment'],
  },
  children: [
    {
      path: 'list',
      component: () => import('@/views/payments/List'),
      name: 'StudentPaymentList',
      meta: { title: 'studentPayment', icon: '', permissions: ['manage studentpayment'] },
    },
    {
      hidden: true,
      path: 'new/:id(\\d+)',
      component: () => import('@/views/payments/NewPayment'),
      name: 'NewStudentPayment',
      meta: { title: 'newStudentPayment', icon: 'studentpayment', permissions: ['manage studentpayment'] },
    },
  ],
};

export default studentPaymentRoutes;
