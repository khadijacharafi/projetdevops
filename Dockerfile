
FROM python:3.8-slim
LABEL maintainer="charafi khadija  <charafikhadija2002@example.com>"

RUN mkdir -p /data

COPY student_age.json /data/student_age.json

WORKDIR /app

COPY . .

RUN apt-get update && \
    apt-get install -y gcc libsasl2-dev libldap2-dev libssl-dev && \
    apt-get clean

RUN python3 -m venv /venv

ENV PATH="/venv/bin:$PATH"

RUN pip install --upgrade pip

RUN pip install --no-cache-dir -r requirements.txt

EXPOSE 8000

CMD ["python", "student_age.py"]