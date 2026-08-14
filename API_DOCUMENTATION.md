# Contact Us API Documentation (V1)

## Base URL
`https://gujjuapp.com/api/v1`

## Authentication
All requests require the `X-API-KEY` header and `Accept: application/json`.

## Endpoints

### [POST] /contact
Submit a new support ticket or feedback.

**Rate Limit:**
- 3 requests per 10 minutes per IP address.

**Request Parameters:**

| Name | Type | Required | Description |
| :--- | :--- | :--- | :--- |
| `name` | String | No | Max 100 chars |
| `email` | String | Yes | Valid email format |
| `phone` | String | No | Max 20 chars |
| `category` | String | Yes | See allowed list below |
| `subject` | String | Yes | Max 255 chars |
| `message` | String | Yes | 10 to 5000 chars |
| `app_version`| String | Yes | e.g. "2.5.0" |
| `platform` | String | Yes | Must be "android" |
| `os_version` | String | Yes | e.g. "13" |
| `device_model`| String | Yes | e.g. "Pixel 7" |
| `device_manufacturer`| String | Yes | e.g. "Google" |
| `language` | String | Yes | e.g. "gu" |
| `country` | String | Yes | e.g. "IN" |
| `user_id` | Integer| No | Internal user ID |

**Allowed Categories:**
`general`, `feedback`, `bug_report`, `feature_request`, `account`, `payment`, `content`, `copyright`, `privacy`, `other`

**Success Response (201 Created):**
```json
{
    "success": true,
    "message": "Your message has been submitted successfully.",
    "data": {
        "request_id": "CNT-20260814-ABC123"
    }
}
```

**Validation Error (422 Unprocessable Entity):**
```json
{
    "success": false,
    "message": "Please correct the highlighted fields.",
    "errors": {
        "email": ["The email field is required."],
        "message": ["The message must be at least 10 characters."]
    }
}
```

**Rate Limit Error (429 Too Many Requests):**
```json
{
    "success": false,
    "message": "Too many requests. Please try again later."
}
```
