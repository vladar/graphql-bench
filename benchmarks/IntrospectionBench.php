<?php
/**
 * @BeforeMethods({"setUp"})
 * @OutputTimeUnit("milliseconds", precision=3)
 * @Warmup(1)
 * @Revs(2)
 * @Iterations(2)
 */
class IntrospectionBench
{
    private $webonyxSource;

    private $digiaSource;

    public function setUp()
    {
        $str = file_get_contents(__DIR__ . '/resources/introspection.graphql');
        $this->webonyxSource = new \GraphQL\Language\Source($str);
        $this->digiaSource = new \Digia\GraphQL\Language\Source($str);
    }

    public function benchWebonyxIntrospectionQuery()
    {
        $lexer = new \GraphQL\Language\Lexer($this->webonyxSource);
        do {
            $token = $lexer->advance();
        } while ($token->kind !== \GraphQL\Language\Token::EOF);
    }

    public function benchDigiaIntrospectionQuery()
    {
        $lexer = new \Digia\GraphQL\Language\Lexer($this->digiaSource, []);
        do {
            $token = $lexer->advance();
        } while ($token->getKind() !== \Digia\GraphQL\Language\TokenKindEnum::EOF);
    }
}
