FROM mysql:5.7

MAINTAINER nii.kunihiro

# timezone の設定
RUN cp -p /usr/share/zoneinfo/Japan /etc/localtime

ADD conf/muscle.cnf /etc/mysql/conf.d/muscle.cnf
ADD ./conf/docker.cnf /etc/mysql/conf.d/docker.cnf
ADD ./conf/mysql.cnf /etc/mysql/conf.d/mysql.cnf

RUN chmod 644 /etc/mysql/conf.d/muscle.cnf
RUN chmod 644 /etc/mysql/conf.d/docker.cnf
RUN chmod 644 /etc/mysql/conf.d/mysql.cnf
