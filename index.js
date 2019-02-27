const faker = require('faker');
const sql = require('sql-query');

const sqlQuery = sql.Query();
const sqlInsert = sqlQuery.insert();

const _sql = [];

for (let i = 0; i < 10; i++) {
    const randomCard = faker.helpers.createCard();

    // gen data
    _sql.push(
        sqlInsert
        .into('userAccount')
        .set({
            username: randomCard.username,
            name: randomCard.name,
            email: randomCard.email,
            hashedPassword: faker.internet.password(),
            isAdmin: 0,
        })
        .build()
    );
}

console.log(_sql.join(";\n"));