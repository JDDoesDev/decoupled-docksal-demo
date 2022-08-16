import { graphql, PageProps } from 'gatsby';
import { GatsbyImage, getImage, IGatsbyImageData } from 'gatsby-plugin-image';
import React, { FC } from 'react';
import Layout from '../Layout/Layout';

const RecipeTemplate: FC<PageProps> = ({data}) => {
  const node = data?.nodeRecipe
  const title = node.title
  const summary = node?.field_summary?.processed
  const ingredients = node?.field_ingredients
  const instructions = node?.field_recipe_instruction?.processed
  const difficulty = node?.field_difficulty
  const cookingTime = node?.field_cooking_time
  const prepTime = node?.field_preparation_time

  return (
    <Layout>
      <h1>{ title }</h1>
      <div dangerouslySetInnerHTML={{
        __html: summary
      }}></div>
      <h2>Difficulty</h2>
      <p>{ difficulty }</p>
      <h2>Cooking Time</h2>
      <p>{ cookingTime }</p>
      <h2>Prep Time</h2>
      <p>{ prepTime }</p>
      <h2>Ingredients</h2>
      <ul>
        { ingredients.map((ingredient, index) => (
          <li key={ index }>{ ingredient }</li>
        )) }
      </ul>
      <h2>Instructions</h2>
      <div dangerouslySetInnerHTML={{
        __html: instructions
      }}></div>
    </Layout>
  )
}

export default RecipeTemplate

export const query = graphql`
  query RecipeTemplate($id: String!) {
    nodeRecipe(id: {eq: $id}) {
      title
      field_summary {
        processed
      }
      field_cooking_time
      field_difficulty
      field_ingredients
      field_number_of_servings
      field_preparation_time
      field_recipe_instruction {
        processed
      }
    }
  }
`
