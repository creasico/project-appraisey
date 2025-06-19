import type { AxiosStatic } from 'axios'

export {}

declare global {
  const axios: AxiosStatic

  interface Window {
    axios: AxiosStatic
  }
}
