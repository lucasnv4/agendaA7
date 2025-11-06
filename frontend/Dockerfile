FROM node:20

WORKDIR /app

# Copia apenas o package.json e lockfile
COPY package*.json ./

# Instala dependências
RUN npm install

# Copia o restante do projeto
COPY . .

EXPOSE 5173

# Define host 0.0.0.0 para permitir acesso externo via Docker
CMD ["npm", "run", "dev", "--", "--host"]
