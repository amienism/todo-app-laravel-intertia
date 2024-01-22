<script setup>
import AuthLayout from "@/Layouts/AuthLayout.vue";

import { useForm } from '@inertiajs/vue3'

const formData = useForm({
    email: null,
    password: null,
});

const handleLogin = () => {
    formData.post('/auth/login');
}

</script>

<template>
    <AuthLayout>
        <div class="container container-tight py-4">
        <div class="text-center mb-4">
          <a href="." class="navbar-brand navbar-brand-autodark">
            <img width="110" height="32" alt="Tabler" class="navbar-brand-image">
          </a>
        </div>
        <div class="card card-md">
          <div class="card-body">
            <h2 class="h2 text-center mb-4">Login to your account</h2>
            <form action="" @submit.prevent="handleLogin">
              <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" :class="formData.errors.email ? 'form-control is-invalid' : 'form-control'" placeholder="your@email.com" autocomplete="off" v-model="formData.email">
                <div class="invalid-feedback" v-if="formData.errors.email">{{ formData.errors.email }}</div>
              </div>
              <div class="mb-2">
                <label class="form-label">
                  Password
                  <span class="form-label-description">
                    <a href="./forgot-password.html">I forgot password</a>
                  </span>
                </label>
                <div class="">
                  <input type="password" :class="formData.errors.password ? 'form-control is-invalid' : 'form-control'" placeholder="Your password" autocomplete="off" v-model="formData.password">
                  <div class="invalid-feedback" v-if="formData.errors.password">{{ formData.errors.password }}</div>
                </div>
              </div>
              <div class="mb-2">
                <label class="form-check">
                  <input type="checkbox" class="form-check-input">
                  <span class="form-check-label">Remember me on this device</span>
                </label>
              </div>
              <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">Sign in</button>
              </div>
            </form>
          </div>
        </div>
        <div class="text-center text-secondary mt-3">
          Don't have account yet? <a href="./sign-up.html" tabindex="-1">Sign up</a>
        </div>
      </div>

    </AuthLayout>
</template>