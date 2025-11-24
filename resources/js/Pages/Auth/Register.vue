<template>
    <AppLayout>
        <div class="register">
            <div class="register__container">
                <h1 class="register__title">Регистрация</h1>
                <form class="register__form" @submit.prevent="submit">
                    <label class="register__label" for="name">Имя</label>
                    <input
                        v-model="form.name"
                        id="name"
                        type="text"
                        required
                        class="register__input"
                    />
                    <p v-if="errors.name" class="register__error">{{ errors.name }}</p>

                    <label class="register__label" for="email">Email</label>
                    <input
                        v-model="form.email"
                        id="email"
                        type="email"
                        required
                        class="register__input"
                    />
                    <p v-if="errors.email" class="register__error">{{ errors.email }}</p>

                    <label class="register__label" for="password">Пароль</label>
                    <input
                        v-model="form.password"
                        id="password"
                        type="password"
                        required
                        class="register__input"
                    />
                    <p v-if="errors.password" class="register__error">{{ errors.password }}</p>

                    <label class="register__label" for="password_confirmation">Подтверждение пароля</label>
                    <input
                        v-model="form.password_confirmation"
                        id="password_confirmation"
                        type="password"
                        required
                        class="register__input"
                    />

                    <button
                        class="register__button"
                        :disabled="processing"
                        type="submit"
                    >
                        {{ processing ? 'Регистрация...' : 'Зарегистрироваться' }}
                    </button>
                </form>

                <p class="register__login-link">
                    <Link :href="route('login')">Уже есть аккаунт? Войти</Link>
                </p>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AppLayout from "@/Components/AppLayout.vue";

const form = reactive({
    email: '',
    password: '',
})

const errors = ref({})
const processing = ref(false)

const submit = () => {
    processing.value = true
    errors.value = {}

    router.post(route('register.post'), form, {
        onSuccess: () => {
            window.location.href = route('home')
        },
        onError: (err) => {
            errors.value = err
        },
        onFinish: () => {
            processing.value = false
        },
    })
}
</script>



<style lang="scss" scoped>
.register {
    &__container {
        max-width: 400px;
        margin: 3rem auto;
        padding: 2rem;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    &__title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1f2937; // gray-900
        margin-bottom: 1.5rem;
        text-align: center;
    }

    &__form {
        display: flex;
        flex-direction: column;
    }

    &__label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151; // gray-700
        margin-bottom: 0.25rem;
    }

    &__input {
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db; // gray-300
        border-radius: 6px;
        font-size: 1rem;
        margin-bottom: 0.75rem;
        outline-offset: 2px;

        &:focus {
            outline: 2px solid #8b4513; // coffee brown
        }
    }

    &__error {
        color: #dc2626; // red-600
        font-size: 0.875rem;
        margin-top: -0.5rem;
        margin-bottom: 0.75rem;
    }

    &__button {
        background-color: #8b4513;
        color: #fff;
        padding: 0.75rem 1rem;
        border-radius: 6px;
        font-weight: 700;
        cursor: pointer;
        transition: background-color 0.2s ease;
        border: none;

        &:hover:not(:disabled) {
            background-color: #654321;
        }

        &:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    }

    &__login-link {
        margin-top: 1rem;
        text-align: center;

        a {
            color: #8b4513;
            font-weight: 600;
            text-decoration: none;

            &:hover {
                color: #654321;
            }
        }
    }
}
</style>
<script setup lang="ts">
</script>
