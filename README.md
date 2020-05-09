# validation-payment-api
Simple API for validation credit card and mobile phone as example on clearly php.

# Endpoins:

## GET \validation\token - get secure token
###### response: {"SecureToken":"9ce04ece68b0c7e3203f07955808c35a"}, status code 200 OK

###### Errors:
status code: 404, message: "Page not found."

## POST \validation\credit-card
Authorization: Bearer Token

###### request body:

1) as JSON format
```
{
 "CreditCardNumber": "string", 
 "ExpirationDate": "string", //correct format is year-month-day
 "CVV2": "integer",
 "Email": "string"
}
```
Example:
```
{
"CreditCardNumber": "1111 2222 3333 4444",
"ExpirationDate": "2020-05-31",
"CVV2": 777,
"Email": "test@gmail.com"
}
```

2) as xml format:
```
<body>
<CreditCardNumber>"1111 2222 3333 4444"</CreditCardNumber>
<ExpirationDate>"2020-05-31"</ExpirationDate>
<CVV2>777</CVV2>
<Email>"test@gmail.com"</Email>
</body>
```

###### response: {"Valid":true}, status code 200 OK

###### Errors:
status code: 400, message: "Parameter Creditcardnumber is required."

status code: 400, message: "Parameter Expirationdate is required."

status code: 400, message: "Parameter CVV2 is required."

status code: 400, message: "Parameter Email is required."

status code: 400, message: "Parameter CreditCardNumber is not valid."

status code: 400, message: "Parameter ExpirationDate is not valid."

status code: 400, message: "Parameter Cvv2 is not valid."

status code: 400, message: "Parameter Email is not valid."

status code: 403, message: "Access denied."

status code: 404, message: "Page not found."

## POST \validation\mobile
Authorization: Bearer Token

###### request body:

1) as JSON format
```
{
 "PhoneNumber": "string" //correct format phone number +38(000)000-00-00
}
```
Example:
```
{
"PhoneNumber": "+38(000)000-00-00"
}
```

2) as xml format:
```
<body>
<PhoneNumber>"+38(000)000-00-00"</PhoneNumber>
</body>
```

###### response: {"Valid":true}, status code 200 OK

###### Errors:
status code: 400, message: "Parameter Phonenumber is required."

status code: 400, message: "Parameter PhoneNumber is not valid."

status code: 403, message: "Access denied."

status code: 404, message: "Page not found."
