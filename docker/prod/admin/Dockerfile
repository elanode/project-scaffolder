# Image
FROM node:14.17-alpine
RUN apk add g++ make python3

COPY ./admin /var/www/admin

WORKDIR /var/www/admin

RUN npm ci && npm run build

ENV HOST=0.0.0.0

CMD ["sh", "-c", "npm run start"]