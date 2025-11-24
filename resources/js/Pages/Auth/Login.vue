<template>
    <AppLayout>
        <div class="login">
            <div class="login__container">
                <h1 class="login__title">Вход в систему</h1>

                <form class="login__form" @submit.prevent="submit">
                    <label class="login__label">Email</label>
                    <input v-model="form.email" type="email" class="login__input"/>
                    <p v-if="errors.email" class="login__error">{{ errors.email }}</p>

                    <label class="login__label">Пароль</label>
                    <input v-model="form.password" type="password" class="login__input"/>
                    <p v-if="errors.password" class="login__error">{{ errors.password }}</p>

                    <button class="login__button" :disabled="processing">
                        {{ processing ? 'Вход...' : 'Войти' }}
                    </button>
                </form>

                <p class="login__register-link">
                    <Link :href="route('register')">Нет аккаунта? Зарегистрироваться</Link>
                </p>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import {reactive, ref} from 'vue'
import {router} from '@inertiajs/vue3'
import {route} from 'ziggy-js'
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

    router.post(route('login.post'), form, {
        onError: (err) => (errors.value = err),
        onFinish: () => (processing.value = false),
    })
}
</script>

<style lang="scss" scoped>
.login {
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
        color: #1f2937;
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
        color: #374151;
        margin-bottom: 0.25rem;
    }

    &__input {
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 1rem;
        margin-bottom: 0.75rem;
        outline-offset: 2px;

        &:focus {
            outline: 2px solid #8b4513;
        }
    }

    &__error {
        color: #dc2626;
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

    &__register-link {
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
