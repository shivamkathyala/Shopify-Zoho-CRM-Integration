# Shopify-Zoho-CRM-Integration
An automated integration solution between Shopify and Zoho CRM. This repository contains a REST API server that utilizes Shopify webhooks to trigger the creation of leads in Zoho CRM. Ensure seamless synchronization of customer data across platforms.

This repository contains a REST API server designed to integrate Shopify and Zoho CRM. The server is configured to receive webhook data from Shopify, verify the headers, obtain Zoho API access tokens, and automatically create leads in Zoho CRM upon a customer creation event in Shopify.

## Setup

1. **Shopify Webhook Configuration:**
   - Set up a Shopify webhook to trigger on customer creation, pointing to the provided endpoint on your server.

2. **Header Verification:**
   - Ensure secure communication by verifying the headers of incoming Shopify webhook requests.

3. **Zoho API Integration:**
   - Obtain Zoho API access tokens using cURL for authentication.

4. **Zoho CRM Lead Creation:**
   - Utilize the Zoho API Insert Request to automatically create leads in Zoho CRM.

## Usage

- Clone the repository and deploy the server on your preferred hosting environment.
- Start the server.

## Dependencies

- PHP
- cURL


