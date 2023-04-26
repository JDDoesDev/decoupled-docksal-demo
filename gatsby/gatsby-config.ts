import type { GatsbyConfig } from "gatsby"
import dotenv from "dotenv"

dotenv.config({
  path: `.env.${process.env.NODE_ENV}`,
});
console.log(process.env.NODE_ENV)
const config: GatsbyConfig = {
  siteMetadata: {
    title: `Decoupled Days Demo`,
    siteUrl: `https://www.yourdomain.tld`,
  },
  // More easily incorporate content into your pages through automatic TypeScript type generation and better GraphQL IntelliSense.
  // If you use VSCode you can also use the GraphQL plugin
  // Learn more at: https://gatsby.dev/graphql-typegen
  graphqlTypegen: true,
  plugins: [
    `gatsby-plugin-sass`,
    `gatsby-plugin-image`,
    `gatsby-plugin-sharp`,
    `gatsby-transformer-sharp`,
    {
      resolve: `gatsby-source-drupal`,
      options: {
        baseUrl: `http://web/`,
        apiBase: `jsonapi`,
      }
    },
    `gatsby-plugin-typescript`,
    {
      resolve: `gatsby-plugin-schema-snapshot`,
      options: {
        path: `${__dirname}/src/schema.gql`,
      },
    },
  ],

}

export default config
