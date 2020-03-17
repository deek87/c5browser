FROM mlocati/docker5:base-7.2

ARG CCM_C5_ARCHIVE='https://www.concrete5.org/download_file/-/view/111592/8497/'

COPY ./entrypoint.sh /

RUN \
    cd /app && \
    ccm-service start db && \
    if test "${CCM_C5_ARCHIVE##*.}" = 'gz'; then \
        curl -sSL "$CCM_C5_ARCHIVE" | sudo -u www-data -- tar xz --strip 1; \
    else \
        curl -sSL -o /tmp/c5.zip "$CCM_C5_ARCHIVE" && \
        sudo -u www-data -- mkdir /tmp/c5 && \
        sudo -u www-data -- unzip -q /tmp/c5.zip -d /tmp/c5 && \
        mv /tmp/c5/*/** /app && \
        rm -rf /tmp/c5.zip /tmp/c5 && \
        chmod +x concrete/bin/concrete5; \
    fi; \
    if ! test -d concrete/vendor; then \
        sudo -u www-data -- composer install --optimize-autoloader --no-suggest && \
        sudo -u www-data -- composer clear-cache; \
    fi;
RUN echo 'Ready.'