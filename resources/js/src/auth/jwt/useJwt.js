import useJwt from '@core/auth/jwt/useJwt'
import axios from '@axios'

const jwtConfig = {
    loginEndpoint: '/api/login',
    registerEndpoint: '/auth/register',
    refreshEndpoint: '/auth/refresh-token',
    logoutEndpoint: '/api/logout',
  
    // This will be prefixed in authorization header with token
    // e.g. Authorization: Bearer <token>
    tokenType: 'Bearer',
  
    // Value of this property will be used as key to store JWT token in storage
    storageTokenKeyName: 'ProcoafAccessToken',
    storageExpiresAt: 'ProcoafExpiresAt',
  }
  
  const { jwt } = useJwt(axios, jwtConfig)
  export default jwt