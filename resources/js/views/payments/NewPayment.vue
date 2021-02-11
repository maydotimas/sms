<template>
  <student-payment :is-edit="true" />
</template>

<script>
import StudentPayment from './components/StudentPaymentDetails';

export default {
  name: 'NewStudentPayment',
  components: { StudentPayment },
};
</script>

