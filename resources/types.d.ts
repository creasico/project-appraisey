/// <reference lib="DOM" />

interface ImportMetaEnv {
  APP_ENV?: 'local' | 'sail' | 'testing' | 'staging' | 'production'
  APP_NAME?: string
  APP_LOCALE?: 'id' | 'en'
  APP_URL?: string
  SENTRY_DSN?: string
  SENTRY_PROFILING_ENABLE?: boolean
}
