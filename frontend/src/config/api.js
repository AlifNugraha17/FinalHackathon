// Centralized API Base URL Configuration for Vite
export const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || ''
export const FONNTE_TOKEN = import.meta.env.VITE_FONNTE_TOKEN || 'RxbepHkDh9uPgw4tx7Ry'

export const getApiUrl = (endpoint) => {
  const cleanEndpoint = endpoint.startsWith('/') ? endpoint : `/${endpoint}`
  return `${API_BASE_URL}${cleanEndpoint}`
}
