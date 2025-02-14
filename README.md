[PHP NlpTools](http://php-nlp-tools.com/)
=============

NlpTools is a set of php classes for beginner to
semi advanced natural language processing work.

This is forked from [php-nlp-tools](https://github.com/angeloskath/php-nlp-tools) and it contains some additions that was helpful for me at the time.

### Added Features ###

1. [Tversky Index](https://en.wikipedia.org/wiki/Tversky_index)
2. [Overlap Coefficient Similarity](https://en.wikipedia.org/wiki/Overlap_coefficient)
3. [Sørensen/Dice Coefficient Similarity](http://en.wikipedia.org/wiki/Sørensen–Dice_coefficient)
4. [Levenshtein Distance](https://en.wikipedia.org/wiki/Levenshtein_distance) - because PHP's levenshtein() implementation is limitted to 255 characters.
5. [Jaro-Winkler Distance](https://en.wikipedia.org/wiki/Jaro%E2%80%93Winkler_distance)
6. WeightedScoring - NLP meets IR.

### Changes ###

1. Optimized getHapaxes method.
2. Extending FreqDist's Term Weighing feature.
```
$freqDist = new FreqDist(array("time", "flies", "like", "an", "arrow"));
$freqDist->getTotalByToken('an');
$freqDist->getTokenWeight('an');
```
3. Extending Idf's global collection stats.
```
$ts = new TrainingSet();
        $ts->addDocument(
            "",
            new TokensDocument(array("a","b","c","d"))
        );
        $ts->addDocument(
            "",
            new TokensDocument(array("a","c","d"))
        );
        $ts->addDocument(
            "",
            new TokensDocument(array("a"))
        );

$idf = new Idf($ts);
printf($idf->idf("b")); //1.098 (exposing it thru a method)
printf($idf->numberofDocuments()); //3
printf($idf->termFrequency("a"));  //3
printf($idf->documentFrequency("b"));  //1
printf($idf->numberofCollectionTokens());  //8
```
4. WeightedScoring.
```
// your documents
$tset = new TrainingSet();
        $tset->addDocument(
            "",
            new TokensDocument(array("this","is","a","big", "fish"))
        );
        $tset->addDocument(
            "",
            new TokensDocument(array("deadpool","is","a","big", "jerk"))
        );
        $tset->addDocument(
            "",
            new TokensDocument(array("i","love","a","big", "salmon"))
        );

$query_tokenized = new TokensDocument(array("big","salmon"));

// select Probabilistic model

$search = new Ranking(new BM25(), $tset);
$search->search($query_tokenized); // Array ( [2] => 2.877.. [0] => 1.660.. [1] => 1.660..) 

// or mixing DFR framework

$search = new DFRRanking(new In(), new B(), new NormalizationH1(), $tset);
$search->search($query_tokenized);

// or select algebraic model

$search = new VectorSpaceModel($tset);
  // or
$search = new PivotedNormalizedVSM($tset);
  // or
$search = new LemurTfIdfVSM($tset);
$search->search($query_tokenized);
```


[Scoring Options](https://github.com/jtejido/php-nlp-tools/tree/master/src/NlpTools/Ranking)
-------------

### Probabilistic Models ###

These are specified via the **Ranking(model, documentset)** class.

***Probabilistic Relevance Models***

1. BM25() - Okapi's Best Matching algorithm.


***Divergence-From-Randomness (DFR)***

1. BB2() - Bernoulli-Einstein model with Bernoulli after-effect and normalization 2.
2. IFB2() - Inverse Term Frequency model with Bernoulli after-effect and normalization 2.
3. InB2() - Inverse Document Frequency model with Bernoulli after-effect and normalization 2.
4. InL2() - Inverse Document Frequency model with Laplace after-effect and normalization 2.
5. PL2() - Poisson model with Laplace after-effect and normalization 2.
6. XSqrA_M() - Inner product of Pearson's X^2 with the information growth computed with the multinomial M.


***Language Models***

1. HiemstraLM() - Based on Hiemstra's [work](https://pdfs.semanticscholar.org/67ba/b01706d3aada95e383f1296e5f019b869ae6.pdf)
2. DirichletLM() - Bayesian smoothing with Dirichlet Prior.
3. JelinekMercerLM() - Based on the Jelinek-Mercer smoothing method.
4. AbsoluteDiscountingLM() - Absolute Discounting smoothing method.
5. TwoStageLM() - Leave-one-out method. This is also a generalization of both DirichletLM and JelinekMercerLM methods.

***Information-based Models***

1. LLDistribution(type) - Log-logistic distribution.
2. SPLDistribution(type) -  Smoothed Power-Law (SPL) distribution.

&nbsp;&nbsp;&nbsp;*Types:*

&nbsp;&nbsp;&nbsp;1 - Document Frequency

&nbsp;&nbsp;&nbsp;2 - Term Frequency


***Divergence-From-Independence (DFI)***

1. DFI(type) - Saturated measure of distance from independence.

&nbsp;&nbsp;&nbsp;*Types:*

&nbsp;&nbsp;&nbsp;1 - Saturated

&nbsp;&nbsp;&nbsp;2 - Chi-squared

&nbsp;&nbsp;&nbsp;3 - Standardized

2. IRRA12() -  Term weighting model developed on the basis of Shannon’s [Information Theory](https://en.wikipedia.org/wiki/Information_theory). 


#### [DFR Framework](http://terrier.org/docs/v4.2/dfr_description.html) ####

DFR models are obtained by instantiating the three components of the framework: 

1. Selecting a basic randomness model.
2. Applying the first normalisation.
3. Normalising the term frequencies.

These are all used via the **DFRRanking(model, aftereffect, normalization, documentset)** class.


***Models:***

1. P() - Approximation of the binomial.
2. BE() - Bose-Einstein distribution.
3. G() - Geometric approximation of the Bose-Einstein.
4. In() - Inverse Document Frequency model.
5. InFreq() - Inverse Term Frequency model.
6. InExp() - Inverse Expected Document Frequency model.


***After Effect:***

1. L() - Laplace’s law of succession.
2. B() - Ratio of two Bernoulli processes.


***Normalization:***

1. NormalizationH1() - Uniform distribution of the term frequency.
2. NormalizationH2() - The term frequency density is inversely related to the length.


### Algebraic Models ###

These are used separately.

1. VectorSpaceModel(documentset) - Classic (D,Q) tf-idf vectors computed thru Cosine similarity.
2. PivotedNormalizedVSM(documentset) - Alternative to cosine normalization that removes a bias inherent in standard length normalization.
3. LemurTfIdfVSM(documentset) - Implementation of Robertson's Tf in tf-idf Vector.


### Work-In-Progress ###

1. Persistent support for indexing.
2. Generalized Vector Space Model (TO-DO)
3. Latent Semantic Indexing (TO-DO, not very much focused on, due to PHP's current speed at SVD's complexity)


Documentation
-------------

You can find documentation and code examples at the project's [homepage](http://php-nlp-tools.com/documentation/).

Contents
---------

### Classification Models ###

1. [Multinomial Naive Bayes](http://php-nlp-tools.com/documentation/bayesian-model.html)
2. [Maximum Entropy (Conditional Exponential model)](http://php-nlp-tools.com/documentation/maximum-entropy-model.html)

### Topic Modeling ###

Lda is still experimental and quite slow but it works. [See an example](http://php-nlp-tools.com/posts/introducing-latent-dirichlet-allocation.html).

1. [Latent Dirichlet Allocation](http://php-nlp-tools.com/documentation/api/#NlpTools/Models/Lda)

### Clustering ###

1. [K-Means](http://php-nlp-tools.com/documentation/clustering.html)
2. [Hierarchical Agglomerative Clustering](http://php-nlp-tools.com/documentation/clustering.html)
   * SingleLink
   * CompleteLink
   * GroupAverage

### Tokenizers ###

1. [WhitespaceTokenizer](http://php-nlp-tools.com/documentation/api/#NlpTools/Tokenizers/WhitespaceTokenizer)
2. [WhitespaceAndPunctuationTokenizer](http://php-nlp-tools.com/documentation/api/#NlpTools/Tokenizers/WhitespaceAndPunctuationTokenizer)
3. [PennTreebankTokenizer](http://php-nlp-tools.com/documentation/api/#NlpTools/Tokenizers/PennTreebankTokenizer)
4. [RegexTokenizer](http://php-nlp-tools.com/documentation/api/#NlpTools\Tokenizers\RegexTokenizer)
5. [ClassifierBasedTokenizer](http://php-nlp-tools.com/documentation/api/#NlpTools/Tokenizers/ClassifierBasedTokenizer)
   This tokenizer allows us to build a lot more complex tokenizers
   than the previous ones

### Documents ###

1. [TokensDocument](http://php-nlp-tools.com/documentation/api/#NlpTools/Documents/TokensDocument)
   represents a bag of words model for a document.
2. [WordDocument](http://php-nlp-tools.com/documentation/api/#NlpTools/Documents/WordDocument)
   represents a single word with the context of a larger document.
3. [TrainingDocument](http://php-nlp-tools.com/documentation/api/#NlpTools/Documents/TrainingDocument)
   represents a document whose class is known.
4. [TrainingSet](http://php-nlp-tools.com/documentation/api/#NlpTools/Documents/TrainingSet)
   a collection of TrainingDocuments

### Feature factories ###

1. [FunctionFeatures](http://php-nlp-tools.com/documentation/api/#NlpTools/FeatureFactories/FunctionFeatures)
   Allows the creation of a feature factory from a number of callables
2. [DataAsFeatures](http://php-nlp-tools.com/documentation/api/#NlpTools/FeatureFactories/DataAsFeatures)
   Simply return the data as features.

### Similarity ###

1. [Jaccard Index](http://php-nlp-tools.com/documentation/api/#NlpTools/Similarity/JaccardIndex)
2. [Cosine similarity](http://php-nlp-tools.com/documentation/api/#NlpTools/Similarity/CosineSimilarity)
3. [Simhash](http://php-nlp-tools.com/documentation/api/#NlpTools/Similarity/Simhash)
4. [Euclidean](http://php-nlp-tools.com/documentation/api/#NlpTools/Similarity/Euclidean)
5. [HammingDistance](http://php-nlp-tools.com/documentation/api/#NlpTools/Similarity/HammingDistance)

### Stemmers ###

1. [PorterStemmer](http://php-nlp-tools.com/documentation/api/#NlpTools/Stemmers/PorterStemmer)
2. [RegexStemmer](http://php-nlp-tools.com/documentation/api/#NlpTools/Stemmers/RegexStemmer)
3. [LancasterStemmer](http://php-nlp-tools.com/documentation/api/#NlpTools/Stemmers/LancasterStemmer)
4. [GreekStemmer](http://php-nlp-tools.com/documentation/api/#NlpTools/Stemmers/GreekStemmer)

### Optimizers (MaxEnt only) ###

1. [A gradient descent optimizer](http://php-nlp-tools.com/documentation/api/#NlpTools/Optimizers/MaxentGradientDescent)
   (written in php) for educational use.
   It is a simple implementation for anyone wanting to know a bit
   more about either GD or MaxEnt models
2. A fast (faster than nltk-scipy), parallel gradient descent
   optimizer written in [Go](http://golang.org/). This optimizer
   resides in another [repo](https://github.com/angeloskath/nlp-maxent-optimizer),
   it is used via the [external optimizer](http://php-nlp-tools.com/documentation/api/#NlpTools/Optimizers/ExternalMaxentOptimizer).
   TODO: At least write a readme for the optimizer written in Go.

### Other ###

1. Idf Inverse document frequency
2. Stop words
3. Language based normalizers
4. Classifier based transformation for creating flexible preprocessing pipelines
