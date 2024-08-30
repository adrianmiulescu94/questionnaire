FROM nginx:1.27.0-alpine


RUN apk add --no-cache --allow-untrusted mkcert --repository=https://dl-cdn.alpinelinux.org/alpine/edge/testing

WORKDIR /var

RUN mkcert -install \
    && mkcert dev.questionnaire

WORKDIR www

CMD ["nginx"]
