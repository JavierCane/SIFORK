<?php

CoverageAnalysis::add( ROOT_PATH . '/libs/Sifo/Benchmark.php' );

/**
 * Test class for Benchmark.
 * Generated by PHPUnit on 2009-11-01 at 12:17:00.
 */
class BenchmarkTest extends PHPUnit_Extensions_ControllerTest
{
    /**
     * @var Benchmark
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new \Sifo\Benchmark;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
		$this->object = null;
    }

	/**
	 * Test object correct creation.
	 */
	public function testObjectCreation()
	{
		$this->assertTrue( $this->object instanceof \Sifo\Benchmark );
	}

	/**
	 * Test singleton.
	 */
	public function testGetInstance()
	{
		$object = \Sifo\Benchmark::getInstance();
		$this->assertTrue( $object instanceof \Sifo\Benchmark );

		$singleton = \Sifo\Benchmark::getInstance();
		$this->assertEquals( $object, $singleton );
	}

	/**
	 * Test some benchmarks.
	 */
	public function testTimer()
	{
		$this->object->timingStart();
		try
		{
			// Linux
			$black_hole = fopen( '/dev/null', 'w' );
		}
		catch ( Exception $e )
		{
			// Windows
			$black_hole = fopen( 'null', 'w' );
		}

		for ( $i = 0; $i < 500; $i++ )
		{
			fputs( $black_hole, $i );
		}

		$current = $this->object->timingCurrent();
		$this->assertInternalType( 'float', $current );
		$this->assertTrue( $current > 0 );

		$this->object->timingStart( 'test' );

		for ( $i = 0; $i < 500; $i++ )
		{
			fputs( $black_hole, $i );
		}

		$this->object->timingStop( 'test' );
		$current = $this->object->timingCurrent( 'test' );
		$this->assertInternalType( 'float', $current );
		$this->assertTrue( $current > 0 );

		fclose( $black_hole );
	}

	/**
	 * Test timingCurrentToRegistry().
	 */
	public function testtimingCurrentToRegistry()
	{
		$this->object->timingStart( 'test' );

		try
		{
			// Linux
			$black_hole = fopen( '/dev/null', 'w' );
		}
		catch ( Exception $e )
		{
			// Windows
			$black_hole = fopen( 'null', 'w' );
		}

		for ( $i = 0; $i < 500; $i++ )
		{
			fputs( $black_hole, $i );
		}

		$this->object->timingStop( 'test' );

		$current = $this->object->timingCurrentToRegistry( 'test' );
		$this->assertInternalType( 'float', $current );
		$this->assertTrue( $current > 0 );
	}
}
?>
