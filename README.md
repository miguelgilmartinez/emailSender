# Email sender microservice

This microservice is subscribed to its own message broker queue and sends an
email for every message it receives, reporting back to the microservice which
made the petition.

## Responsibilities

1. Send email
2. Report back to the microservice which triggered the email request.

## Sends data to message broker

1. MESSAGE_SUCCESSFUL
2. MESSAGE_ERROR

## Is subscribed to

1. EMAIL_PETITION
