<template>
    <AppLayout>
        <div class="register">
            <div class="register__container">
                <h1 class="register__title">Регистрация</h1>

                <!-- общий alert ошибок (например, неожиданные) -->
                <div v-if="globalErrors.length" class="register__alert" role="alert">
                    <ul>
                        <li v-for="(g, i) in globalErrors" :key="i">{{ g }}</li>
                    </ul>
                </div>

                <form class="register__form" @submit.prevent="submit">
                    <label class="register__label" for="name">Имя</label>
                    <input
                        v-model="form.name"
                        id="name"
                        type="text"
                        class="register__input"
                    />
                    <p v-if="errors.name" class="register__error">{{ errors.name }}</p>

                    <label class="register__label" for="email">Email</label>
                    <input
                        v-model="form.email"
                        id="email"
                        type="email"
                        class="register__input"
                    />
                    <p v-if="errors.email" class="register__error">{{ errors.email }}</p>

                    <label class="register__label" for="password">Пароль</label>
                    <input
                        v-model="form.password"
                        id="password"
                        type="password"
                        class="register__input"
                    />
                    <p v-if="errors.password" class="register__error">{{ errors.password }}</p>

                    <label class="register__label" for="password_confirmation">Подтверждение пароля</label>
                    <input
                        v-model="form.password_confirmation"
                        id="password_confirmation"
                        type="password"
                        class="register__input"
                    />
                    <p v-if="errors.password_confirmation" class="register__error">{{ errors.password_confirmation }}</p>

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
import { reactive, ref, watch } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import AppLayout from "@/Components/AppLayout.vue";

const page = usePage()

const form = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const errors = ref({})
const processing = ref(false)

// global errors array (for fallback or unexpected)
const globalErrors = ref([])

// следим за props.errors от Inertia (серверная валидация)
watch(
    () => page.props?.value?.errors,
    (newErrors) => {
        const safe = newErrors ?? {}

        errors.value = safe

        globalErrors.value = []

        if (safe.non_field_errors) {
            globalErrors.value.push(...safe.non_field_errors)
        }

        if (typeof safe.message === "string") {
            globalErrors.value.push(safe.message)
        }
    }
)


const submit = () => {
    processing.value = true
    errors.value = {}
    globalErrors.value = []

    router.post(route('register.post'), form, {
        onSuccess: () => {
            // после успешной регистрации редирект на home (Inertia обработает)
            // но если нужен рендер без редиректа, можно возвращать Inertia::render в контроллере
        },
        onError: (err) => {
            // Inertia иногда передаёт объект ошибок напрямую в onError
            // Преобразуем в удобный вид: err — объект: { field: ['msg1','msg2'], ... }
            if (err && typeof err === 'object') {
                const mapped = {}
                Object.keys(err).forEach(k => {
                    mapped[k] = Array.isArray(err[k]) ? err[k][0] : err[k]
                })
                errors.value = mapped
            }
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

    &__alert {
        background: #fff5f5;
        border: 1px solid #fecaca;
        color: #b91c1c;
        padding: 0.75rem 1rem;
        border-radius: 6px;
        margin-bottom: 1rem;

        ul {
            margin: 0;
            padding-left: 1.2rem;
        }
    }
}
</style>
